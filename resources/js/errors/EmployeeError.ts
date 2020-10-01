export default class EmployeeError extends Error {
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
