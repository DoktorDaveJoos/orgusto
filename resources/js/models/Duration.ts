import Reservation from "./Reservation";

export interface Duration {
    h: string,
    m: string
}

export default class DurationClass implements Duration {
    private _h: string;
    private _m: string;

    constructor(h: string, m: string) {
        this._h = h;
        this._m = m;
    }

    get h(): string {
        return this._h;
    }

    set h(value: string) {
        this._h = value;
    }

    get m(): string {
        return this._m;
    }

    set m(value: string) {
        this._m = value;
    }

    public static boilerPlate(): DurationClass {
        return new DurationClass("2", "00");
    }

    public static ofJson(dur: any): DurationClass {
        if (DurationClass.instanceOfDuration(dur)) {
            return new DurationClass(dur.h, dur.m);
        } else {
            return DurationClass.boilerPlate();
        }
    }

    public static instanceOfDuration(object: any): object is Duration {
        if (!(object instanceof Object)) object = Object.assign({}, object);
        return "h" in object && "m" in object;
    }

}
