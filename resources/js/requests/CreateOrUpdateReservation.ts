import _ from 'lodash';
import AbstractRequest from "./AbstractRequest";
import Reservation from "../models/Reservation";
import Table from "../models/Table";

export default class CreateOrUpdateReservation extends AbstractRequest{

    reservation: Reservation;

    constructor(reservation: Reservation) {
        super();
        this.reservation = reservation;
    }

    asJsonPayload(): any {
        let request = Object.assign({});

        request.start = this.reservation.start.date;
        request.persons = this.reservation.persons;
        request.user_id = this.reservation.user.id;
        request.duration = this.reservation.duration.asJson();

        request.tables = _.cloneDeep(this.reservation.tables.tables)
            .map((table: Table) => table.id);

        request.name = this.reservation.name;
        request.email = this.reservation.email;
        request.color = this.reservation.color;
        request.notice = this.reservation.notice;
        request.phone_number = this.reservation.phone_number;

        return request;
    }

}
