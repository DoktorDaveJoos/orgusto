export default class ReservationError extends Error {
  constructor(message: string) {
    super(message);
    this.name = 'ReservationError';
  }

  public static of(message: string): ReservationError {
    return new ReservationError(message);
  }

  public static failedParsing(object: any): ReservationError {
    return new ReservationError(`Not an instance of Reservation: ${JSON.stringify(object)}`);
  }
}
