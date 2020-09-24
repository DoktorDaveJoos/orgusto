/**
 * DateString
 * Handles valid date string for backend.
 */

import moment from 'moment';
import Duration from "./Duration";

export default class DateString {

    private _date: string;

    constructor(date: string) {
        this._date = date;
    }

    get date(): string {
        return this._date;
    }

    set date(value: string) {
        this._date = moment(value).format("YYYY-MM-DD HH:mm:ss");
    }

    public static ofAny(date: any): DateString {
        return new DateString(moment(date).format("YYYY-MM-DD HH:mm:ss"));
    }

    public static addDuration(init: DateString, duration: Duration): DateString {
        const date = init.date;
        const withAdd = moment(date).add(duration.h, "hours").add(duration.m, "minutes");
        return DateString.ofAny(withAdd);
    }

    public static now(): DateString {
        return DateString.ofAny(new Date());
    }

    public asDate(): Date {
        return moment(this.date).toDate();
    }

    public readableDate(): string {
        return moment(this.date).format("DD.MM.YYYY");
    }

    public addDays(days: number): void {
        this.date = moment(this.date).add(days, "days").toISOString();
    }

    public isToday(): boolean {
        return moment(moment().format("YYYY-MM-DD")).isSame(moment(this.date));
    }

    public diffDaysFromNow(): number {
        const now = moment(moment().format("YYYY-MM-DD"));
        return moment(this.date).diff(now, 'day');
    }
}

