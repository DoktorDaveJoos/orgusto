import _ from "lodash";

import Duration from "./Duration";
import Tables from "./Tables";
import DateString from "./DateString";
import DurationClass from "./Duration";

export default interface Reservation {
    name: string,
    duration: Duration,
    persons: number,
    start: DateString,
    end: DateString,
    notice?: string,
    color: string,
    email?: string,
    phone_number?: string,
    tables: Tables
}

export class ReservationClass implements Reservation {
    private _color: string;
    private _duration: Duration;
    private _email: string;
    private _end: DateString;
    private _name: string;
    private _notice: string;
    private _persons: number;
    private _phone_number: string;
    private _start: DateString;
    private _tables: Tables;

    constructor(color: string, duration: Duration, email: string, end: DateString, name: string, notice: string, persons: number, phone_number: string, start: DateString, tables: Tables) {
        this._color = color;
        this._duration = duration;
        this._email = email;
        this._end = end;
        this._name = name;
        this._notice = notice;
        this._persons = persons;
        this._phone_number = phone_number;
        this._start = start;
        this._tables = tables;
    }

    public static instanceOfReservation(object: any): object is Reservation {
        return 'color' in object &&
            'name' in object &&
            'duration' in object &&
            'persons' in object &&
            'start' in object &&
            'end' in object &&
            'notice' in object &&
            'email' in object &&
            'phone_number' in object &&
            'tables' in object;
    }

    static of(object: any): Reservation {
        if (ReservationClass.instanceOfReservation(object)) {
            return new ReservationClass(
                object.color,
                object.duration,
                object.email,
                object.end,
                object.name,
                object.notice,
                object.persons,
                object.phone_number,
                object.start,
                object.tables
            )
        }
    }

    public static empty(): ReservationClass {
        return new ReservationClass(
            "gray",
            DurationClass.boilerPlate(),
            null,
            DateString.addDuration(DateString.now(), DurationClass.boilerPlate()),
            "",
            "",
            0,
            null,
            DateString.now(),
            Tables.empty()
        )
    }

    static copyFromReservation(old: Reservation): Reservation {
        if (ReservationClass.instanceOfReservation(old)) {
            return _.cloneDeep(old);
        } else return ReservationClass.empty();
    }

    get tables(): Tables {
        return this._tables;
    }

    set tables(value: Tables) {
        this._tables = value;
    }

    get color(): string {
        return this._color;
    }

    get duration(): Duration {
        return this._duration;
    }

    get email(): string {
        return this._email;
    }

    get end(): DateString {
        return this._end;
    }

    get name(): string {
        return this._name;
    }

    get notice(): string {
        return this._notice;
    }

    get persons(): number {
        return this._persons;
    }

    get phone_number(): string {
        return this._phone_number;
    }

    get start(): DateString {
        return this._start;
    }


    set color(value: string) {
        this._color = value;
    }

    set duration(value: Duration) {
        this._duration = value;
    }

    set email(value: string) {
        this._email = value;
    }

    set end(value: DateString) {
        this._end = value;
    }

    set name(value: string) {
        this._name = value;
    }

    set notice(value: string) {
        this._notice = value;
    }

    set persons(value: number) {
        this._persons = value;
    }

    set phone_number(value: string) {
        this._phone_number = value;
    }

    set start(value: DateString) {
        this._start = value;
    }

}
