import DateString from "../models/DateString";
import Filter from "../models/Filter";

import $ from 'jquery';
import Duration from "../models/Duration";

export default class TablesRequest {

    private _filter: Filter;

    constructor(filter: Filter) {
        this._filter = filter;
    }

    get filter(): Filter {
        return this._filter;
    }

    set filter(value: Filter) {
        this._filter = value;
    }

    public static of(filter: Filter): TablesRequest {
        return new TablesRequest(filter);
    }

    get queryParams(): string {
        const simplified: any = {
            start: this.filter.date.date,
            m: this.filter.duration.minutes,
            persons: this.filter.persons
        }
        return $.param(simplified);
    }
}
