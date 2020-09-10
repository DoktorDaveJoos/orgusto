import Table from "./Table";
import _ from 'lodash';


export default class Tables {
    private _tables?: Array<Table>

    constructor(tables?: Array<Table>) {
        this._tables = tables ?? [];
    }

    get tables(): Array<Table> {
        return this._tables;
    }

    set tables(value: Array<Table>) {
        this._tables = value;
    }

    public static empty(): Tables {
        return new Tables();
    }

    public static of(tablesObj: any) {
        return new Tables(tablesObj);
    }

    merge(newTables: Tables) {
        this._tables = _.union(this.tables, newTables);
        this._tables.sort((a, b) => a.table_number - b.table_number);
    }
}
