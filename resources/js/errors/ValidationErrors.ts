export class NotEmptyError extends Error {
  constructor(message: string) {
    super(message);
    this.name = 'NotEmptyError';
  }

  public static of(message: string): NotEmptyError {
    return new NotEmptyError(message);
  }
}

export class InvalidIDError extends Error {
  constructor(message: string) {
    super(message);
    this.name = 'InvalidIDError';
  }

  public static of(id: any): InvalidIDError {
    const message = id instanceof String ? id : id.toString();
    return new InvalidIDError(message);
  }
}
