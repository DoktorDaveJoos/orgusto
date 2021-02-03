import checkNotEmpty from "../helper/CheckNotEmpty";
import checkId from "../helper/CheckId";
import parseObject from "../helper/ParseObject";
import EmployeeError from "../errors/EmployeeError";
import _ from 'lodash';

interface BasicEmployee {
    id: number,
    name: string,
    email: string,
    type: string,
    access_level: string
}

export default class Employee implements BasicEmployee {
    private _id: number;
    private _access_level: string;
    private _email: string;
    private _name: string;
    private _type: string;

    constructor(id: number, access_level: string, email: string, name: string, type: string) {
        this._id = id;
        this._access_level = access_level;
        this._email = email;
        this._name = name;
        this._type = type;
    }

    get id(): number {
        return this._id;
    }

    set id(value: number) {
        this._id = value;
    }

    get access_level(): string {
        return this._access_level;
    }

    set access_level(value: string) {
        this._access_level = value;
    }

    get email(): string {
        return this._email;
    }

    set email(value: string) {
        this._email = value;
    }

    get name(): string {
        return this._name;
    }

    set name(value: string) {
        this._name = value;
    }

    get type(): string {
        return this._type;
    }

    set type(value: string) {
        this._type = value;
    }

    public equals(other: Employee): boolean {
        return _.isEqual(this, other);
    }

    public static check(object: any): object is Employee | Error {
        const newEmployee = parseObject(object);
        const isEmployee = "name" in newEmployee &&
            "email" in newEmployee &&
            "type" in newEmployee &&
            "access_level" in newEmployee;
        if (!isEmployee) throw EmployeeError.failedParsing(object);
        else return isEmployee;
    }

    public static of(object: any): Employee {

        // Empty user for empty reservation.
        if (object === null) {
            return new EmployeeBuilder()
                .buildEmpty();
        }

        Employee.check(object);

        const newEmployee = parseObject(object);
        return new EmployeeBuilder()
            .withId(newEmployee.id)
            .withName(newEmployee.name)
            .withAccessLevel(newEmployee.access_level)
            .withEmail(newEmployee.email)
            .withType(newEmployee.email)
            .build();
    }

}

export class EmployeeBuilder implements BasicEmployee {
    id: number;
    access_level: string;
    email: string;
    name: string;
    type: string;

    constructor() {
        this.id = -1;
        this.access_level = "";
        this.email = "";
        this.name = "";
        this.type = "";
    }

    public withId(id: number): EmployeeBuilder {
        this.id = id;
        return this;
    }

    public withName(name: string): EmployeeBuilder {
        this.name = name;
        return this;
    }

    public withEmail(email: string): EmployeeBuilder {
        this.email = email;
        return this;
    }

    public withAccessLevel(accessLevel: string): EmployeeBuilder {
        this.access_level = accessLevel;
        return this;
    }

    public withType(type: string): EmployeeBuilder {
        this.type = type;
        return this;
    }

    public build(): Employee {
        checkId(this.id);
        checkNotEmpty(this.access_level);
        checkNotEmpty(this.name);
        checkNotEmpty(this.type);

        return new Employee(this.id, this.access_level, this.email, this.name, this.type);
    }

    /**
     * Builds empty employee.
     */
    public buildEmpty(): Employee {
        return new Employee(this.id, this.access_level, this.email, this.name, this.type);
    }
}
