import {setHours, startOfDay, parseISO} from 'date-fns';

const makeDefaultTimelineStart = () => {
  const date = new Date().toISOString();
  return setHours(startOfDay(parseISO(date)), 17);
};

export default {
  timelineStart: makeDefaultTimelineStart(),
  singleDate: new Date(),
  showFulfilled: false,
  dateRange: {
    start: new Date(),
    end: new Date(),
  },
  dateFilter: {
    active: false,
    mode: 'none',
  },
  past: false,
};
