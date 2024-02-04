import React, {useEffect} from 'react';
import {useSelector} from 'react-redux';
import {useTranslation} from 'react-i18next';
import {NavLink, useLocation} from 'react-router-dom';
import {useAppDispatch} from '@/redux';
import {selectNotificationsCount} from '@/redux/notifications/selectors';
import {fetchNotificationsCount} from '@/redux/notifications/thunks';
import {useAuthProvider} from '@/context/auth/AuthProvider';
import {TabListComponent} from '@components/UI/Tabs/Tabs';
import TabItem from '@components/UI/Tabs/TabItem';
import {setPathname} from '@/redux/router/slice';
import {RoutePath} from '@/constants/navigation';
import UserMenu from './UserMenu';
import Logo from './Logo';

function Navigation() {
  const {t} = useTranslation();
  const location = useLocation();
  const dispatch = useAppDispatch();
  const {user} = useAuthProvider();

  const notificationsCount = useSelector(selectNotificationsCount);

  useEffect(() => {
    dispatch(setPathname(location?.pathname as RoutePath));
  }, [dispatch, location?.pathname]);

  useEffect(() => {
    if (notificationsCount === null && user?.uid) {
      void dispatch(fetchNotificationsCount());
    }
  }, [notificationsCount, user?.uid]);

  if (!user) {
    return null;
  }

  return (
    <div className="static bg-white border-b border-b-grey-3">
      <div className="flex flex-row justify-between items-center p-3">
        <Logo />

        <div className="flex-1 py-2 flex ml-6">
          <TabListComponent>
            <TabItem id={RoutePath.Appointments} activeTab={location.pathname}>
              <NavLink to={RoutePath.Appointments}>{t('navigation.appointments')}</NavLink>
            </TabItem>
            <TabItem id={RoutePath.Calendar} activeTab={location.pathname}>
              <NavLink to={RoutePath.Calendar}>{t('navigation.calendar')}</NavLink>
            </TabItem>
            <TabItem id={RoutePath.Notifications} activeTab={location.pathname}>
              <NavLink to={RoutePath.Notifications}>
                {t('navigation.notifications')} ({notificationsCount || 0})
              </NavLink>
            </TabItem>
          </TabListComponent>
        </div>

        <div className="grow-0">
          <UserMenu />
        </div>
      </div>
    </div>
  );
}
export default Navigation;
