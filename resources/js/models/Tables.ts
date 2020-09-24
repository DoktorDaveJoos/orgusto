import Table from "./Table";
import _ from 'lodash';
import TableClass from "./Table";


export default class Tables {
    private _tables: Array<Table>;

    constructor(tables: Array<Table>) {
        tables.map(table => TableClass.of(table));
        this._tables = tables ?? [];
    }

    get tables(): Array<Table> {
        return this._tables;
    }

    set tables(value: Array<Table>) {
        if (value.length > 0) {
            value.map(table => TableClass.of(table));
        }
        this._tables = value;
    }

    public static empty(): Tables {
        return new Tables([] as Table[]);
    }

    public static of(tablesObj: any) {
        if (tablesObj instanceof Tables) return _.cloneDeep(tablesObj);
        return new Tables(_.cloneDeep(tablesObj));
    }

    merge(newTables: []): void {
        newTables.map(table => TableClass.of(table));
        this.tables = _.unionBy(this.tables, newTables, 'id');
        this.tables = this.tables.sort(((a, b) => a.table_number - b.table_number));
    }

    mergeTable(newTable: Table): void {
        if (this.tables.find(table => table.id === newTable.id) === undefined) {
            this.tables.push(newTable);
        }
    }

    mergeTableOrElseRemove(newTable: Table): void {
        if (this.tables.find(table => table.id === newTable.id) === undefined) {
            this.tables.push(newTable);
        } else {
            this.tables = this.tables.filter(table => table.id !== newTable.id);
        }
    }
}
