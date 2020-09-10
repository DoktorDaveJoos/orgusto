export interface Table {
    table_number: number;
    seats: number;
    restaurant_id: number;
    room?: number;
    description?: string
}

export default class TableClass implements Table{
    description: string;
    restaurant_id: number;
    room: number;
    seats: number;
    table_number: number;

    constructor(description: string, restaurant_id: number, room: number, seats: number, table_number: number) {
        this.description = description;
        this.restaurant_id = restaurant_id;
        this.room = room;
        this.seats = seats;
        this.table_number = table_number;
    }


}
