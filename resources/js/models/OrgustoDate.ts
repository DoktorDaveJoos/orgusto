/**
 * OrgustoDate
 * Handles all date and time operations for orgusto.
 *
 * TODO: fix API for ofAny -> ofString, ofDate
 * TODO: fix API -> getter instead of functional returns -> readableDate & readableTime
 */

import {
    format,
    addDays,
    addHours,
    addMinutes,
    isToday,
    isEqual,
    differenceInDays,
    setYear,
    setMonth,
    setDay,
    getYear,
    getMonth,
    getDay,
    setHours,
    getHours,
    setMinutes,
    getMinutes,
    startOfToday
} from 'date-fns';

export default class OrgustoDate {

    private readonly _date: Date;

    private constructor(date: Date) {
        this._date = new Date(date);
    }

    get hour(): number {
        return getHours(this.asDate);
    }

    get minute(): number {
        return getMinutes(this.asDate);
    }

    get asDate(): Date {
        return this._date;
    }

    get asISO(): string {
        return this._date.toISOString();
    }

    get readableDate(): string {
        return format(this.asDate, "dd.MM.yyyy");
    }

    get readableTime(): string {
        return format(this.asDate, "HH:mm");
    }

    get isToday(): boolean {
        return isToday(this.asDate);
    }

    get diffDaysFromNow(): number {
        return differenceInDays(new Date(), this.asDate);
    }

    public format(_format: string): string {
        return format(this.asDate, _format);
    }

    /**
     * Returns an instance of OrgustoDate
     * @param date: any
     * @return {@link OrgustoDate}
     * @deprecated - use {@link #ofDate} or {@link #ofString} instead
     */
    public static ofAny(date: any): OrgustoDate {

        if (date instanceof Date) {
            return new OrgustoDate(date);
        }

        return new OrgustoDate(new Date(date));
    }

    /**
     * Returns an instance of OrgustoDate
     * @param date: {@link Date}
     * @return {@link OrgustoDate}
     */
    public static ofDate(date: Date): OrgustoDate {
        return new OrgustoDate(date);
    }

    /**
     * Returns an instance of OrgustoDate
     * @param date: {@link String}
     * @return {@link OrgustoDate}
     */
    public static ofString(date: string): OrgustoDate {
        return new OrgustoDate(new Date(date));
    }

    /**
     * Returns an instance of OrgustoDate with new Date().
     * @return {@link OrgustoDate}
     * @deprecated - use {@link #default} instead
     */
    public static now(): OrgustoDate {
        return OrgustoDate.ofAny(new Date());
    }

    public static default(): OrgustoDate {
        return OrgustoDate.ofDate(startOfToday()).setHours(18).setMinutes(0);
    }

    public addDays(days: number): OrgustoDate {
        return new OrgustoDate(addDays(this.asDate, days));
    }

    public addHours(hours: number): OrgustoDate {
        return new OrgustoDate(addHours(this.asDate, hours));
    }

    public addMinutes(minutes: number): OrgustoDate {
        return new OrgustoDate(addMinutes(this.asDate, minutes));
    }

    public isSame(toCompare: OrgustoDate): boolean {
        return isEqual(this.asDate, toCompare.asDate);
    }

    public setDateOnly(newDate: Date): OrgustoDate {
        let tmpDate = this.asDate;
        tmpDate = setYear(tmpDate, getYear(newDate));
        tmpDate = setMonth(tmpDate, getMonth(newDate));
        tmpDate = setDay(tmpDate, getDay(newDate));
        return OrgustoDate.ofDate(tmpDate);
    }

    public setTimeOnly(newDate: Date): OrgustoDate {

        let tmpDate = this.asDate;
        setHours(tmpDate, getHours(newDate));
        setMinutes(tmpDate, getMinutes(newDate));
        return OrgustoDate.ofAny(tmpDate);

    }

    public setHours(hours: number): OrgustoDate {
        return OrgustoDate.ofAny(setHours(this.asDate, hours));
    }

    public setMinutes(minutes: number): OrgustoDate {
        return OrgustoDate.ofAny(setMinutes(this.asDate, minutes));
    }
}

