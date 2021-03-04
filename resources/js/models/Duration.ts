export interface BasicDuration {
    minutes: number;
}

export default class Duration implements BasicDuration {
    private _minutes: number;

    constructor(minutes: number) {
        this._minutes = minutes;
    }

    get minutes(): number {
        return this._minutes;
    }

    set minutes(value: number) {
        this._minutes = value;
    }

    get h(): number {
        return Math.floor(this.minutes / 60);
    }

    set h(value: number) {
        this.minutes = this.m + value * 60;
    }

    get m(): number {
        return this.minutes % 60;
    }

    set m(value: number) {
        this.minutes = this.h * 60 + value;
    }

    asJson(): any {
        return {"h": this.h, "m": this.m};
    }

    public static boilerPlate(): Duration {
        return new Duration(120);
    }

    /**
     * Returns a Duration Object from a JSON Object
     * @param dur Json representation of Duration
     *
     * @deprecated
     */
    public static ofJson(dur: any): Duration {
        const newDuration: any = JSON.parse(dur);
        if (!Duration.instanceOfOldDuration(newDuration)) {
            throw new Error(`Not an instance of OldDuration: ${dur}`);
        }
        const h: number = !isNaN(newDuration.h) ? parseInt(newDuration.h.toString()) : newDuration.h;
        const m: number = !isNaN(newDuration.h) ? parseInt(newDuration.m.toString()) : newDuration.m;
        return new Duration(h * 60 + m);
    }

    /**
     * Returns a Duration Object from a given hour and a minute
     * @param hour
     * @param minute
     *
     * @deprecated - use {@link #ofMinutes} instead.
     */
    public static of(hour: number, minute: number): number {
        return hour * 60 + minute;
    }

    /**
     * Returns a Duration Object from given minutes
     * @param minutes
     */
    public static ofMinutes(minutes: number): Duration {
        return new Duration(minutes);
    }

    public static instanceOfOldDuration(object: any): object is Duration {
        if (!(object instanceof Object)) object = Object.assign({}, object);
        return "h" in object && "m" in object;
    }

    public equals(duration: Duration): boolean {
        return this.minutes === duration.minutes;
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
