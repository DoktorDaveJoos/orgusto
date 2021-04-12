import {setHours, setMinutes, startOfToday} from 'date-fns';

const createEmptyReservation = () => {
  let defaultDate = startOfToday();
  defaultDate = setHours(defaultDate, 18);
  defaultDate = setMinutes(defaultDate, 0);

  return {
    id: null,
    color: 'gray',
    duration: 120,
    name: null,
    notice: null,
    phone_number: null,
    persons: 2,
    email: null,
    start: defaultDate.toISOString(),
    tables: [],
    user: null,
    done: false,
  };
};

export {createEmptyReservation};
