import _ from "lodash";

import Duration from "./Duration";
import Tables from "./Tables";
import OrgustoDate from "./OrgustoDate";
import Employee from "./Employee";
import parseObject from "../helper/ParseObject";
import ReservationError from "../errors/ReservationError";

export interface BasicReservation {
    name: string | null,
    duration: Duration,
    persons: number,
    start: OrgustoDate,
    notice?: string | null,
    color: string,
    email?: string | null,
    phone_number?: string | null,
    tables: Tables,
    user: Employee | null;
}

export default class Reservation implements BasicReservation {
    private _color: string;
    private _duration: Duration;
    private _email: string | null;
    private _name: string | null;
    private _notice: string | null;
    private _persons: number;
    private _phone_number: string | null;
    private _start: OrgustoDate;
    private _tables: Tables;
    private _user: Employee | null;

    // TODO refactor for optional? parameters with BuilderPattern
    constructor(color: string,
                duration: Duration,
                email: string | null,
                name: string | null,
                notice: string | null,
                persons: number,
                phone_number: string | null,
                start: OrgustoDate,
                tables: Tables,
                user: Employee | null) {
        this._color = color;
        this._duration = duration;
        this._email = email;
        this._name = name;
        this._notice = notice;
        this._persons = persons;
        this._phone_number = phone_number;
        this._start = start;
        this._tables = tables;
        this._user = user;
    }

    public static check(object: any): object is BasicReservation {
        const newReservation: any = parseObject(object);
        const isReservation = 'color' in newReservation &&
            'name' in newReservation &&
            'duration' in newReservation &&
            'persons' in newReservation &&
            'start' in newReservation &&
            'notice' in newReservation &&
            'email' in newReservation &&
            'phone_number' in newReservation &&
            'tables' in newReservation &&
            'user' in newReservation;
        if (!isReservation) throw ReservationError.failedParsing(object);
        else return isReservation;
    }

    static ofOrEmpty(object: any): Reservation {
        if (object === undefined || object === null) {
            return Reservation.empty();
        } else {
            return Reservation.of(object);
        }
    }

    static of(object: any): Reservation {

        Reservation.check(object)

        const newReservation: any = parseObject(object);

        return new Reservation(
            newReservation.color,
            Duration.ofMinutes(newReservation.duration),
            newReservation.email ? newReservation.email : null,
            newReservation.name,
            newReservation.notice ? newReservation.notice : null,
            newReservation.persons,
            newReservation.phone_number ? newReservation.phone_number : null,
            OrgustoDate.ofAny(newReservation.start),
            Tables.of(newReservation.tables),
            Employee.of(newReservation.user)
        )
    }

    static empty(): Reservation {
        return new Reservation(
            "gray",
            Duration.ofMinutes(120),
            null,
            "",
            null,
            2,
            null,
            OrgustoDate.default(),
            Tables.empty(),
            null
        )
    }

    static copyFromReservation(old: Reservation): Reservation {
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

    get name(): string | null {
        return this._name;
    }

    get persons(): number {
        return this._persons;
    }

    get start(): OrgustoDate {
        return this._start;
    }

    set color(value: string) {
        this._color = value;
    }

    set duration(value: Duration) {
        this._duration = value;
    }

    set name(value: string | null) {
        this._name = value;
    }

    set persons(value: number) {
        this._persons = value;
    }

    set start(value: OrgustoDate) {
        this._start = value;
    }

    get user(): Employee | null {
        return this._user;
    }

    set user(value: Employee | null) {
        this._user = value;
    }
}
