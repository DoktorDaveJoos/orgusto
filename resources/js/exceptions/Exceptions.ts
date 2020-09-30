export class ReservationError extends Error {
    constructor(message: string) {
        super(message);
        this.name = "ReservationError"
    }

    public static of(message: string): ReservationError {
        return new ReservationError(message);
    }

    public static failedParsing(object: any): ReservationError {
        return new ReservationError(`Not an instance of Reservation: ${object}`);
    }
}

export class EmployeeError extends Error {
    constructor(message: string) {
        super(message);
        this.name = "EmployeeError"
    }

    public static of(message: string): EmployeeError {
        return new EmployeeError(message);
    }

    public static failedParsing(object: any): EmployeeError {
        return new EmployeeError(`Not an instance of Employee: ${object}`);
    }
}

export class NotEmptyError extends Error {
    constructor(message: string) {
        super(message);
        this.name = "NotEmptyError"
    }

    public static of(message: string): NotEmptyError {
        return new NotEmptyError(message);
    }
}

export class InvalidIDError extends Error {
    constructor(message: string) {
        super(message);
        this.name = "InvalidIDError"
    }

    public static of(id: any): InvalidIDError {
        const message = id instanceof String ? id : id.toString();
        return new InvalidIDError(message);
    }
}
