import _ from "lodash";

import Duration from "./Duration";
import Tables from "./Tables";
import DateString from "./DateString";
import DurationClass from "./Duration";

export interface Reservation {
    name: string,
    duration: Duration,
    persons: number,
    start: DateString,
    end: DateString,
    notice?: string | null,
    color: string,
    email?: string | null,
    phone_number?: string | null,
    tables: Tables
}

export default class ReservationClass implements Reservation {
    private _color: string;
    private _duration: Duration;
    private _email: string | null;
    private _end: DateString;
    private _name: string;
    private _notice: string | null;
    private _persons: number;
    private _phone_number: string | null;
    private _start: DateString;
    private _tables: Tables;

    constructor(color: string, duration: Duration, email: string | null, end: DateString, name: string, notice: string | null, persons: number, phone_number: string | null, start: DateString, tables: Tables) {
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
                DurationClass.ofJson(object.duration),
                object.email ? object.email : null,
                DateString.ofAny(object.end),
                object.name,
                object.notice ? object.notice : null,
                object.persons,
                object.phone_number ? object.phone_number : null,
                DateString.ofAny(object.start),
                Tables.of(object.tables)
            )
        }
        return ReservationClass.empty();
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

    get email(): string | null {
        return this._email;
    }

    get notice(): string | null {
        return this._notice;
    }

    get phone_number(): string | null {
        return this._phone_number;
    }

    set email(value: string | null) {
        this._email = value;
    }

    set notice(value: string | null) {
        this._notice = value;
    }

    set phone_number(value: string | null) {
        this._phone_number = value;
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

    get end(): DateString {
        return this._end;
    }

    get name(): string {
        return this._name;
    }

    get persons(): number {
        return this._persons;
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



    set end(value: DateString) {
        this._end = value;
    }

    set name(value: string) {
        this._name = value;
    }



    set persons(value: number) {
        this._persons = value;
    }


    set start(value: DateString) {
        this._start = value;
    }

}
