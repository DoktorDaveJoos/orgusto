import DateString from "../models/DateString";
import Filter from "../models/Filter";

import $ from 'jquery';

export default class TablesRequest {

    private _start: DateString;
    private _end: DateString;

    constructor(start: DateString, end: DateString) {
        this._start = start;
        this._end = end;
    }

    get start(): DateString {
        return this._start;
    }

    set start(value: DateString) {
        this._start = value;
    }

    get end(): DateString {
        return this._end;
    }

    set end(value: DateString) {
        this._end = value;
    }

    public static of(filter: Filter): TablesRequest {
        const start = DateString.ofAny(filter.date);
        const end = DateString.addDuration(start, filter.duration);
        return new TablesRequest(start, end);
    }

    get queryParams(): string {
        const simplified: any = {
            start: this.start.date,
            end: this.end.date
        }
        return $.param(simplified);
    }
}
