import Duration from "./Duration";

import moment from 'moment';
import DateString from "./DateString";
import Reservation from "./Reservation";

export interface Filter {
    date?: DateString;
    duration?: Duration;
    persons?: number;
}

export default class FilterClass implements Filter {
    private _date: DateString;
    private _duration: Duration;
    private _persons: number;

    constructor(date: DateString, duration: Duration, persons: number) {
        this._date = date;
        this._duration = duration;
        this._persons = persons;
    }

    get date(): DateString {
        return this._date;
    }

    set date(value: DateString) {
        this._date = value;
    }

    get duration(): Duration {
        return this._duration;
    }

    set duration(value: Duration) {
        this._duration = value;
    }

    get persons(): number {
        return this._persons;
    }

    set persons(value: number) {
        this._persons = value;
    }

    public static of(reservation: Reservation): Filter {
        const date = DateString.ofAny(reservation.start);

        return new FilterClass(
            date,
            reservation.duration,
            reservation.persons
        );

    }
}
// processedEndDate() {
//     return moment(this.processedDate)
//         .add("hours", this.duration.h)
//         .add("minutes", this.duration.m)
//         .format("YYYY-MM-DD HH:mm[:00]");
// },
