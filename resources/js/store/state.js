import {setHours, setMinutes, startOfDay, parseISO} from 'date-fns';

const makeDefaultTimelineStart = () => {
  const date = new Date().toISOString();
  return setHours(startOfDay(parseISO(date)), 17);
};

export default {
  reservations: {
    items: [],
    links: {},
    meta: {},
    errors: [],
  },
  filter: {
    showFulfilled: false,
    dateRange: {
      start: new Date(),
      end: new Date(),
    },
    singleDate: new Date(),
    dateFilter: {
      active: false,
      mode: 'none',
    },
    past: false,
    timelineStart: makeDefaultTimelineStart(),
  },
  user: {},
  restaurant: {
    id: null,
    users: [],
    tables: [],
    allTables: [],
    settings: {},
  },
  modal: {
    isOpen: false,
    activeReservationId: null,
    newReservation: {},
  },
  loadingStates: {
    reservations: false,
    employees: false,
    tables: false,
  },
  search: {
    query: '',
  },
};
