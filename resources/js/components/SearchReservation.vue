<template>
    <div class="w-full max-w-5xl flex justify-between content-center h-12 mb-6">
        <!-- Search -->
        <div
            class="group mt-1 relative rounded-full border-2 border-gray-400 focus-within:border-blue-400 shadow-lg bg-white pl-10 flex flex-row w-2/3 mr-4"
        >
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <span class="text-gray-600 sm:text-sm sm:leading-5 mx-2">
          <i class="fas fa-search"></i>
        </span>
            </div>
            <input
                id="reservations.search"
                class="bg-white pl-2 form-input block w-full rounded-full sm:text-sm sm:leading-5 focus:outline-none"
                placeholder="Search name, email, phone number..."
                v-model="searchQuery"
                v-on:keyup.enter="handleSubmit"
            />
            <div
                v-if="isShowingRecommendations"
                class="origin-top-right absolute right-0 mt-12 w-full border border-gray-400 bg-white rounded-lg shadow-lg"
            >
                <div
                    v-if="hasResults"
                    role="menu"
                    aria-orientation="vertical"
                    aria-labelledby="options-menu"
                >
                    <div class="py-2">
                        <span class="p-4 text-sm text-gray-600">Recommendations:</span>
                    </div>
                    <hr/>
                    <div v-for="result in results" :key="result.id" class="py-1">
                        <a
                            :href="reservationEndpoint + '/' + result.id"
                            class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900 text-left"
                            role="menuitem"
                        >
                            <span v-html="result.name"></span>
                            <span
                                class="text-xs text-gray-500"
                                :class="result.found_notice ? '' : 'hidden'"
                                v-html="result.notice"
                            ></span>
                            <span
                                class="text-xs text-gray-500"
                                :class="result.found_email ? '' : 'hidden'"
                                v-html="result.email"
                            ></span>
                            <span
                                class="text-xs text-gray-500"
                                :class="result.found_phone_number ? '' : 'hidden'"
                                v-html="result.phone_number"
                            ></span>
                        </a>
                    </div>
                    <div class="border-t border-gray-200"></div>
                </div>
                <div v-else class="p-4">
                    <div class="flex flex-row">
                        <div class="flex content-center pr-4 pl-2 items-center">
                            <div>
                                <i class="fas fa-exclamation-triangle text-gray-700"></i>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-700">Sorry, we could not find anything.</p>
                            <p class="text-sm text-gray-500">Please check your search term.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter -->
            <button
                @click="isShowingFilter = !isShowingFilter"
                class="focus:outline-none leading-tight h-full w-12 rounded-r-full transition-colors duration-150 ease-in-out"
                :class="isShowingFilter ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-600'"
            >
                <span class="sm:text-sm sm:leading-5 mx-2 self-center">
                  <i class="fas fa-filter"></i>
                </span>
            </button>

            <div
                v-if="isShowingFilter && !isShowingRecommendations"
                class="origin-top-right absolute right-0 mt-12 w-full border border-gray-400 bg-white rounded-lg shadow-lg"
            >
                <div class="bg-white rounded-lg">
                    <div class="py-2">
                        <span class="p-4 text-sm text-gray-700">Available filters:</span>
                    </div>
                    <hr/>
                    <div>

<!--                        show fulfilled-->
                        <label class="flex items-center p-4">
                            <input type="checkbox" class="form-checkbox" v-model="fulfilled">
                            <span class="ml-2 text-sm text-gray-600">Show fulfilled</span>
                        </label>



                    </div>
                </div>
            </div>
        </div>

        <!-- Date filter -->
        <div
            class="group mt-1 relative rounded-full border-2 border-gray-400 focus-within:border-blue-400 shadow-lg bg-white flex flex-row w-1/3">
            <div class="w-full flex justify-center">
                <button
                    id="options-menu"
                    @click="isShowingDateFilter = !isShowingDateFilter"
                    type="button"
                    class="flex w-full h-full items-center rounded-full px-4 py-2 bg-white text-sm leading-5 font-medium text-gray-600 hover:text-indigo-500 focus:outline-none focus:outline-none transition ease-in-out duration-150"
                    aria-haspopup="true"
                    aria-expanded="true"
                >
                    <i v-if="quickFilterIncludes" class="fas fa-fast-forward pointer-events-none"></i>
                    <i v-else class="fas fa-calendar-day pointer-events-none"></i>
                    <span class="flex w-full justify-center pointer-events-none">
                        {{ dateFilter }}

                    </span>
                </button>
            </div>
            <div
                id="dateFilterDetail"
                v-if="isShowingDateFilter"
                class="origin-bottom-left border border-gray-400 absolute mt-12 w-full right-auto rounded-md shadow-lg"
            >
                <div class="rounded-md bg-white shadow-xs">
                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        <button
                            v-for="entry in filteredQuickFilter"
                            :key="entry"
                            @click="setDateFilter(entry)"
                            class="block w-full px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900 text-center"
                            role="menuitem"
                        >
                            <div class="flex justify-between items-center">
                                <i class="fas fa-fast-forward text-gray-500 hover:text-gray-600"></i>
                                <div class="flex-1 text-center">{{ entry }}</div>
                            </div>
                        </button>

                        <v-date-picker
                            mode="range"
                            v-model="range"
                            :popover="{ placement: 'bottom', visibility: 'click' }"
                        >
                            <button
                                href="#"
                                class="block w-full px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900 text-center"
                                role="menuitem"
                            >
                                <div
                                    id="dateFilterDetailgeneralDiv"
                                    class="flex justify-between items-center hover:text-gray-800"
                                >
                                    <i id="dateFilterDetailIcon" class="fas fa-calendar-alt text-gray-500"></i>
                                    <div id="dateFilterDetailDiv" class="flex-1 text-center">Date range</div>
                                </div>
                            </button>
                        </v-date-picker>
                    </div>
                </div>
            </div>

            <v-date-picker v-model="singleDate" :popover="{ placement: 'bottom', visibility: 'click' }">
                <button
                    class="focus:outline-none bg-gray-200 leading-tight focus:bg-indigo-600 focus:text-white text-gray-600 h-full w-12 rounded-r-full transition-colors duration-150 ease-in-out"
                >
          <span class="sm:text-sm sm:leading-5 mx-2 self-center">
            <i class="fas fa-calendar-alt"></i>
          </span>
                </button>
            </v-date-picker>
        </div>
        <button
            @click="handleSubmit"
            class="ml-4 focus:outline-none px-4 text-sm leading-tight mt-1 relative rounded-full font-semibold border-2 border-indigo-300 bg-indigo-100 text-indigo-500 hover:border-indigo-700 hover:bg-indigo-600 hover:text-white shadow-lg text-center transition-colors duration-150 ease-in-out"
        >
            <div class="flex row justify-between items-baseline">
                <div class="mr-2">Update</div>
                <div>
                    <i class="fas fa-redo"></i>
                </div>
            </div>
        </button>
    </div>
</template>

<script>
export default {
    name: "search-reservations-bar",
    props: ["searchEndpoint", "reservationEndpoint"],
    mounted: function () {
        document.addEventListener("click", e =>
            this.handleClickOutside(e.target.id)
        );

        const url = new URL(location.href);
        this.urlSearchQuery = this.searchQuery =
            url.searchParams.get("searchQuery") ?? "";

        var from = url.searchParams.get("from");
        var to = url.searchParams.get("to");
        if (from && to) {
            from = moment(from);
            to = moment(to);

            if (
                moment()
                    .startOf("day")
                    .diff(from, "days") === -1
            ) {
                this.dateFilter = "Tomorrow";
            } else if (from.diff(to, "weeks") === -1) {
                this.dateFilter = "Next week";
            } else if (from.diff(to, "months") === -1) {
                this.dateFilter = "Next month";
            } else if (from.isSame(to)) {
                this.singleDate = from;
            } else {
                this.range = {start: from, end: to};
            }
        }
    },
    data() {
        return {
            results: [],
            searchQuery: "",
            searchQueryIsDirty: false,
            isShowingRecommendations: false,
            isCalculating: false,
            isShowingFilter: false,
            isShowingDateFilter: false,
            dateFilter: "Today",
            dateModeIndicator: "fastForward",
            urlSearchQuery: "",
            range: {
                start: new Date(),
                end: new Date()
            },
            singleDate: new Date(),
            quickFilter: ["Today", "Tomorrow", "Next week", "Next month"],
            fulfilled: new URLSearchParams(window.location.search).has('fulfilled')
        };
    },
    methods: {
        handleClickOutside: function (id) {
            if (id !== "options-menu" && !id.includes("dateFilterDetail")) {
                this.isShowingDateFilter = false;
            }
            this.isShowingRecommendations = false;
        },
        searchOnType: function () {
            if (this.searchQuery !== this.urlSearchQuery) {
                axios
                    .post(this.searchEndpoint, {
                        searchQuery: this.searchQuery,
                        from: this.dateForRequest.from,
                        to: this.dateForRequest.to
                    })
                    .then(res => {
                        this.results = res.data;
                    })
                    .catch(err => {
                        // TODO handle Error
                    });
            } else {
                this.urlSearchQuery = "";
            }
        },
        expensiveOperation: _.debounce(function () {
            this.isCalculating = true;
            setTimeout(() => {
                this.searchOnType();
            }, 50);
        }, 50),
        handleSubmit: function () {
            var queryParams = {};

            if (this.searchQuery.length > 0)
                queryParams.searchQuery = this.searchQuery;
            if (this.dateFilter !== "Today") {
                queryParams.from = this.dateForRequest.from;
                queryParams.to = this.dateForRequest.to;
            }
            queryParams = $.param(queryParams);

            if (queryParams.length > 0) queryParams = "?" + queryParams;

            const queryString = this.reservationEndpoint + queryParams;
            location.assign(queryString);
        },
        setDateFilter: function (val) {
            this.dateModeIndicator = "fastForward";
            this.dateFilter = val;
        }
    },
    watch: {
        searchQuery: function () {
            this.searchQueryIsDirty = true;
            this.expensiveOperation();
            if (this.searchQuery === "") {
                this.isShowingRecommendations = false;
            }
        },
        range: function () {
            const from = moment(this.range.start).format("DD.MM.YY");
            const to = moment(this.range.end).format("DD.MM.YY");
            this.dateFilter = from + " → " + to;
            this.dateModeIndicator = "range";
            this.isShowingDateFilter = false;
        },
        singleDate: function () {
            this.dateFilter = "↓ " + moment(this.singleDate).format("DD.MM.YY");
            this.dateModeIndicator = "singleDate";
        },
        results: function () {
            this.isShowingRecommendations = this.searchQuery.length > 0;
        },
        fulfilled() {
            if (this.fulfilled === true) {
                const queryParams = new URLSearchParams(window.location.search);
                const filler = queryParams.has('from') ? '&' : '?';
                location.href =
                    location.href + filler + "fulfilled=true";
            } else {
                const queryParams = new URLSearchParams(window.location.search);
                if (queryParams.has('fulfilled')) {
                    queryParams.delete('fulfilled');
                    let newUrl = location.href;
                    newUrl = newUrl.replace(location.search, '');
                    const filler = queryParams.toString().length > 0 ? '?' : '';
                    location.href = newUrl + filler + queryParams.toString();
                }
            }
        }
    },
    computed: {
        filteredQuickFilter: function () {
            return this.quickFilter.filter(a => a !== this.dateFilter);
        },
        quickFilterIncludes: function () {
            return this.quickFilter.includes(this.dateFilter);
        },
        hasResults: function () {
            return this.results.length > 0;
        },
        dateForRequest: function () {
            var from = moment();
            var to;
            if (this.dateModeIndicator === "fastForward") {
                if (this.dateFilter === "Today") {
                    to = from;
                } else if (this.dateFilter === "Tomorrow") {
                    to = moment().add(1, "days");
                    from = to;
                } else if (this.dateFilter === "Next week") {
                    to = moment().add(1, "week");
                } else if (this.dateFilter === "Next month") {
                    to = moment().add(1, "month");
                }
            } else if (this.dateModeIndicator === "singleDate") {
                from = moment(this.singleDate);
                to = from;
            } else if (this.dateModeIndicator === "range") {
                from = moment(this.range.start);
                to = moment(this.range.end);
            }
            from = from.format("YYYY-MM-DD");
            to = to.format("YYYY-MM-DD");
            return {from: from, to: to};
        }
    }
};
</script>

<style>
</style>
