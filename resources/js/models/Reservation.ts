import _ from "lodash";

import Duration from "./Duration";
import Tables from "./Tables";
import DateString from "./DateString";
import Employee from "./Employee";
import parseObject from "../helper/ParseObject";
import ReservationError from "../errors/ReservationError";

export interface BasicReservation {
    name: string,
    duration: Duration,
    persons: number,
    start: DateString,
    end: DateString,
    notice?: string | null,
    color: string,
    email?: string | null,
    phone_number?: string | null,
    tables: Tables,
    user: Employee
}

export default class Reservation implements BasicReservation {
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
    user: Employee;

    constructor(color: string, duration: Duration, email: string | null, end: DateString, name: string, notice: string | null, persons: number, phone_number: string | null, start: DateString, tables: Tables, user: Employee) {
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
        this.user = user;
    }

    public static instanceOfReservation(object: any): object is BasicReservation {
        const newReservation: any = parseObject(object);
        const isReservation = 'color' in newReservation &&
            'name' in newReservation &&
            'duration' in newReservation &&
            'persons' in newReservation &&
            'start' in newReservation &&
            'end' in newReservation &&
            'notice' in newReservation &&
            'email' in newReservation &&
            'phone_number' in newReservation &&
            'tables' in newReservation &&
            'user' in newReservation;
        if (!isReservation) throw ReservationError.failedParsing(object);
        else return isReservation;
    }

    static of(object: any): BasicReservation {
        try {
            Reservation.instanceOfReservation(object)
        } catch (err: any) {
            console.error(err)
        }
        const newReservation: any = parseObject(object);

        return new Reservation(
            newReservation.color,
            Duration.ofJson(newReservation.duration),
            newReservation.email ? newReservation.email : null,
            DateString.ofAny(newReservation.end),
            newReservation.name,
            newReservation.notice ? newReservation.notice : null,
            newReservation.persons,
            newReservation.phone_number ? newReservation.phone_number : null,
            DateString.ofAny(newReservation.start),
            Tables.of(newReservation.tables),
            Employee.of(newReservation.user)
        )
    }

    static copyFromReservation(old: BasicReservation): BasicReservation {
        return _.cloneDeep(old);
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
