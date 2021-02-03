import Duration from "./Duration";
import OrgustoDate from "./OrgustoDate";
import Reservation from "./Reservation";

export interface BasicFilter {
    date?: OrgustoDate;
    duration?: Duration;
    persons?: number;
}

export default class Filter implements BasicFilter {
    private _date: OrgustoDate;
    private _duration: Duration;
    private _persons: number;

    constructor(date: OrgustoDate, duration: Duration, persons: number) {
        this._date = date;
        this._duration = duration;
        this._persons = persons;
    }

    get date(): OrgustoDate {
        return this._date;
    }

    set date(value: OrgustoDate) {
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
        const date = reservation.start;
        return new Filter(
            date,
            reservation.duration,
            reservation.persons
        );

    }
}
