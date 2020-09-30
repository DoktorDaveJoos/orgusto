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
        return this.asMoment().toDate();
    }

    public readableDate(): string {
        return this.asMoment().format("DD.MM.YYYY");
    }

    public addDays(days: number): void {
        this.date = this.asMoment().add(days, "days").toISOString();
    }

    public isToday(): boolean {
        return moment(moment().format("YYYY-MM-DD")).isSame(this.asMoment());
    }

    public diffDaysFromNow(): number {
        const now = moment(moment().format("YYYY-MM-DD"));
        return this.asMoment().diff(now, 'day');
    }

    public asMoment(): moment.Moment {
        return moment(this.date);
    }

    public setDateOnly(newDate: DateString): void {
        this.date = this.asMoment()
            .set('year', newDate.asMoment().get('year'))
            .set('month', newDate.asMoment().get('month'))
            .set('date', newDate.asMoment().get('date'))
            .toISOString();
    }

    public setTimeOnly(newDate: DateString): void {
        this.date = this.asMoment()
            .set('hour', newDate.asMoment().get('hour'))
            .set('minute', newDate.asMoment().get('minute'))
            .toISOString();
    }
}

