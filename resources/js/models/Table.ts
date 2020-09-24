export interface Table {
    id: number;
    table_number: number;
    seats: number;
    restaurant_id: number;
    room?: number;
    description?: string
}

export default class TableClass implements Table {
    description: string;
    restaurant_id: number;
    room: number;
    seats: number;
    table_number: number;
    id: number;
    1

    constructor(id: number, description: string, restaurant_id: number, room: number, seats: number, table_number: number) {
        this.id = id;
        this.description = description;
        this.restaurant_id = restaurant_id;
        this.room = room;
        this.seats = seats;
        this.table_number = table_number;
    }

    public static of(object: any): Table {
        if ('pivot' in object) delete object.pivot;
        return new TableClass(object.id, object.description, object.restaurant_id, object.room, object.seats, object.table_number);
    }

}
