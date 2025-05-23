import dayjs from 'dayjs';

export const today = dayjs().format('YYYY-MM-DD');
export const startOfWeek = dayjs().startOf('week').format('YYYY-MM-DD');
export const endOfWeek = dayjs().endOf('week').format('YYYY-MM-DD');
export const startOfMonth = dayjs().startOf('month').format('YYYY-MM-DD');
export const endOfMonth = dayjs().endOf('month').format('YYYY-MM-DD');

export const formatDate = (date) => dayjs(date).format('DD.MM.YYYY');
