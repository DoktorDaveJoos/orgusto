import Reservation from "./BasicReservation";

export interface Duration {
    h: number,
    m: number
}

export default class DurationClass implements Duration {
    private _h: number;
    private _m: number;

    constructor(h: number, m: number) {
        this._h = h;
        this._m = m;
    }

    get h(): number {
        return this._h;
    }

    set h(value: number) {
        this._h = value;
    }

    get m(): number {
        return this._m;
    }

    set m(value: number) {
        this._m = value;
    }

    public static boilerPlate(): DurationClass {
        return new DurationClass(2, 0);
    }

    public static ofJson(dur: any): DurationClass {
        const newDuration: any = JSON.parse(dur);
        if (!DurationClass.instanceOfDuration(newDuration)) {
            throw new Error(`Not an instance of Duration: ${dur}`);
        }
        const h: number = !isNaN(newDuration.h) ? parseInt(newDuration.h.toString()) : newDuration.h;
        const m: number = !isNaN(newDuration.h) ? parseInt(newDuration.m.toString()) : newDuration.m;
        return new DurationClass(h, m);
    }

    public static of(hour: number, minute: number): DurationClass {
        return new DurationClass(hour, minute);
    }

    public static instanceOfDuration(object: any): object is Duration {
        if (!(object instanceof Object)) object = Object.assign({}, object);
        return "h" in object && "m" in object;
    }

    public equals(duration: DurationClass): boolean {
        return this.h === duration.h && this.m === duration.m;
    }

    public print(): string {

        let minute: string;
        if (this.m === 0) {
            minute = "";
        } else if (this.m <= 9) {
            minute = `0${this.m.toString()}`;
        } else {
            minute = this.m.toString();
        }
        const separator: string = minute !== "" ? ":" : "";

        return this.h.toString() + separator + minute + "h";
    }

}
