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
}
