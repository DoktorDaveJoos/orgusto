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
}

