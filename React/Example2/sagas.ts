import {call, fork, put, take, select, delay} from 'redux-saga/effects';
import {eventChannel} from 'redux-saga';
import type {Notification} from '@/redux/notifications/types';
import {attachNewChatMessage, chatMessageReceived} from '@/redux/chats/actions';
import {UserMessageType} from '@/redux/notifications/types';
import {fetchNewAppointment} from '@/redux/appointments/thunks';
import {fetchSlot, updateSlotOccupancy} from '@/redux/slots/thunks';
import {getPathname} from '@/redux/router/selectors';
import type {AppointmentDto} from '@/axiosApi/backend';
import {RoutePath} from '@/constants/navigation';
import {
  addInboxNotification,
  incrementInboxNotificationsCount,
} from '@/redux/notifications/slice';
import {isMessageRequiredNotification} from '@components/Agora/Chat/utils';
import {
  selectActiveAppointment,
  selectLatestAppointmentsForuserId,
} from '@/redux/appointments/selectors';
import {NotificationsType} from '@/constants/notifications';
import type {NotificationOptions} from '@/shared/types/notifications';
import {NotificationTimeoutType, NotificationUrgencyLevels} from '@/shared/types/notifications';
import {showInfo} from '@/redux/snackbar/slice';
import {MessageType} from '@components/Agora/Chat/interfaces';
import {channels} from '@/redux/notifications/constants';
import type {AgoraChat} from 'agora-chat';
import {
  getMessageNotifications,
  resolveAgoraMessageParticipants,
  saveNewMessageNotification,
} from '@/redux/chats/utils';
import {fetchNotifications} from '@/redux/notifications/thunks';
import {selectUser} from '@/redux/auth/selectors';
import {selectFhirUser} from '@/redux/medData/selectors';

function notificationsChannel() {
  return eventChannel((emit) => {
    window.electronAPI?.subscribeIncomingNotifications((notifications) => {
      notifications.forEach((notification) => {
        emit(notification);
      });
    });
  });
}

function* watchNotifications() {
  const channel = yield call(notificationsChannel);
  try {
    while (true) {
      const notification = yield take(channel);
      yield call(dispatchNotification, notification);
    }
  } finally {
    console.log('%cNotifications channel closed', 'color: red');
  }
}

export function* trackEvent(message: AgoraChat.TextMsgBody | AgoraChat.CustomMsgBody) {
  const user = yield select(selectUser);
  window.electronAPI.analytics.trackMessageReceiving({
    userId: message.from,
    userID: user?.uid,
  });
}

export function* dispatchNotification(notification: Notification) {
  const pathname = yield select(getPathname);

  if (pathname === RoutePath.Notifications) {
    yield put(addInboxNotification(notification));
  }

  if (pathname !== RoutePath.Notifications) {
    yield put(incrementInboxNotificationsCount());
  }

  yield put({type: channels.notificationReceived, payload: notification});
}

function* watchFetchNotifications() {
  while (true) {
    const action = yield take(fetchNotifications.fulfilled);
    if (!fetchNotifications.fulfilled.match(action)) {
      continue;
    }
    const user = yield select(selectUser);
    const chatNotifications = getMessageNotifications(user?.uid);
    yield put({
      type: `${fetchNotifications.typePrefix}/fulfilled`,
      payload: action.payload.concat(chatNotifications).sort((a, b) => b.createdAt - a.createdAt),
    });
  }
}

function* watchMessages() {
  while (true) {
    const action = yield take(chatMessageReceived);
    if (!chatMessageReceived.match(action)) {
      continue;
    }

    const msg = yield call(resolveAgoraMessageParticipants, action.payload);
    const fromPatient = yield select(selectFhirUser(msg.from));
    const pathname = yield select(getPathname);

    const username = fromPatient.name[0].text;

    const notification = {
      id: msg.id,
      isSeen: pathname === RoutePath.Notifications,
      isRead: pathname === RoutePath.Notifications,
      createdAt: msg?.time || msg?.created_at,
      type: UserMessageType.NEW_CHAT_MESSAGE,
      message:
        msg?.type === MessageType.TXT || msg?.type === MessageType.REGULAR
          ? (msg?.msg || msg?.text)
          : '[file]',
      title: `New message from user`,
      image: null,
      actionData: msg.from,
      target: [msg.to],
    };

    const appointment = yield select(selectActiveAppointment);
    const latestAppointment = yield select(selectLatestAppointmentsForuserId(msg.from));

    yield put(
      attachNewChatMessage({
        userId: msg.from,
        message: msg,
      })
    );

    if (
      appointment.userId.toLowerCase() === msg.from.toLowerCase() &&
      pathname === `${RoutePath.Appointments}${RoutePath.Visits}/${appointment.id}${RoutePath.Chat}`
    ) {
      return;
    }

    saveNewMessageNotification(notification);
    yield call(dispatchNotification, notification as Notification);

    const isSendNotification = isMessageRequiredNotification(
      msg,
      appointment,
      latestAppointment,
      location
    );

    if (isSendNotification) {
      const title = {
        [MessageType.TXT]: `NEW MESSAGE (${username}): ${msg?.msg}`,
        [MessageType.REGULAR]: `NEW MESSAGE (${username}): ${msg?.text}`,
        [MessageType.CUSTOM]: `NEW FILE (${username})`,
      }[msg.type];

      yield sendNotification({
        notification: {
          title,
          onInAppClick: {type: 'OpenNewMessageButton', message: msg},
        },
        type: NotificationsType.Broadcast,
      });

      yield call(trackEvent, msg);
    }
  }
}

function* sendOSNotification(notification: NotificationOptions) {
  yield call(window.electronAPI.sendOSNotification, {
    title: notification.title,
    hasReply: !notification?.hasReply,
    body: notification?.body || null,
    urgency: notification?.urgency || NotificationUrgencyLevels.Normal,
    timeoutType: notification?.timeoutType || NotificationTimeoutType.Default,
    silent: !notification?.silent,
  });
}

function* sendInAppNotification(notification: NotificationOptions) {
  yield put(
    showInfo({
      id: Date.now(),
      message: notification.body || notification.title,
      action: notification.onInAppClick,
      displayingTime: notification.displayingTime,
    })
  );
}

export function* sendNotification(params: {
  notification: NotificationOptions;
  type: NotificationsType;
}) {
  switch (params.type) {
    case NotificationsType.OS:
      yield sendOSNotification(params.notification);
      break;
    case NotificationsType.InApp:
      yield sendInAppNotification(params.notification);
      break;
    case NotificationsType.Broadcast:
      yield sendInAppNotification(params.notification);
      yield sendOSNotification(params.notification);
      break;
    default:
      break;
  }
}

function* watchForAppointments() {
  while (true) {
    const action = yield take(channels.notificationReceived);
    if (!action.payload) {
      continue;
    }
    const notification = action.payload as unknown as Notification;
    if (notification.type === UserMessageType.EVENT_CREATE) {
      yield delay(2000);

      yield sendNotification({
        notification: {
          title: notification.message,
        },
        type: NotificationsType.Broadcast,
      });

      yield fork(function* () {
        const result = yield yield put(fetchNewAppointment(notification.actionData));
        const {slotId} = result.payload as AppointmentDto;
        yield yield put(fetchSlot(slotId));
        yield yield put(updateSlotOccupancy(slotId));
      });
    }
  }
}

export const notificationSagas = [
  watchNotifications,
  watchMessages,
  watchForAppointments,
  watchFetchNotifications,
];
