import dayjs from 'dayjs';
import {BASE_DATE_FORMAT, BASE_DATE_TIME_FORMAT} from '@/constants/datetimeFormats';

export const flatObject = (source, ...parents) => {
  const mergedValue = {};
  for (const [key, value] of Object.entries(source)) {
    const path = (parents || []).concat(key);
    if (typeof value === 'object') {
      Object.assign(mergedValue, flatObject(value, ...path));
      continue;
    }
    let k = path.join('][');
    const idx = k.indexOf(']');
    if (idx !== -1) {
      k = k.replace(/]/, '').concat(']');
    }

    mergedValue[k] = value;
  }
  return mergedValue;
}

export const now = () => Date.now();

export const formatted = (date: string | number | Date, format?: string): string => {
  return dayjs(date).format(format || 'YYYY MMM DD');
};

export const formattedNow = (format?: string) => formatted(now(), format || BASE_DATE_TIME_FORMAT);

export const toNow = (date: string, withoutSuffix?: boolean): string => {
  return dayjs(date).toNow(withoutSuffix);
};

export const formatLocalDate = (timestamp: string | number) =>
  dayjs.utc(timestamp).local().format('HH:mm:ss YYYY.MM.DD').toString();

export const formatTimeInMinutes = (seconds: number) => {
  const hours = Math.floor(Math.abs(seconds) / 3600);
  const minutes = Math.floor((Math.abs(seconds) % 3600) / 60);

  const formattedHours = String(Math.abs(Number(hours))).padStart(2, '0');
  const formattedMinutes = String(Math.abs(Number(minutes))).padStart(2, '0');
  return `${formattedHours !== '00' ? formattedHours + ':' : ''}${formattedMinutes}`;
};

export const formatTimeInSeconds = (seconds: number) => {
  const hours = Math.floor(seconds / 3600);
  const minutes = Math.floor((seconds % 3600) / 60);
  const remainingSeconds = seconds % 60;

  const formattedHours = String(Math.abs(Number(hours))).padStart(2, '0');
  const formattedMinutes = String(Math.abs(Number(minutes))).padStart(2, '0');
  const formattedSeconds = String(Math.abs(Number(remainingSeconds))).padStart(2, '0');

  return `${formattedHours}:${formattedMinutes}:${formattedSeconds}`;
};

export const startYearDate = (year?: number | string) => {
  if (year) {
    return formatted(
      dayjs().year(Number(year)).startOf('year').toString(),
      BASE_DATE_FORMAT
    ).toString();
  } else {
    return formatted(
      dayjs()
        .year(dayjs(new Date(null)).year())
        .startOf('year')
        .toString(),
      BASE_DATE_FORMAT
    ).toString();
  }
};

export const endYearDate = (year: number | string) =>
  formatted(dayjs().year(Number(year)).endOf('year').toString(), BASE_DATE_FORMAT).toString();

export const startMonthDate = (year: number | string, month: number | string) =>
  formatted(
    dayjs().year(Number(year)).month(Number(month)).startOf('month').toString(),
    BASE_DATE_FORMAT
  ).toString();

export const endMonthDate = (year: number | string, month: number | string) =>
  formatted(
    dayjs().year(Number(year)).month(Number(month)).endOf('month').toString(),
    BASE_DATE_FORMAT
  ).toString();

export const isDateBefore = (firstDate: any, secondDate: any) => {
  return firstDate.isBefore(secondDate);
};
