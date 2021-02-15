export default {
    reservations: {
        items: [],
        links: {},
        meta: {},
        errors: []
    },
    filter: {
        showFulfilled: false,
        dateRange: {
            start: new Date(),
            end: new Date()
        },
        singleDate: new Date(),
        dateFilter: {
            active: false,
            mode: "none"
        }
    },
    user: {},
    restaurant: {
        users: [],
        tables: [],
        settings: {}
    },
    modal: {
        isOpen: false,
        activeReservationId: null,
        newReservation: {},
    },
    loadingStates: {
        reservations: false,
        employees: false,
        tables: false,
    },
    search: {
        query: ""
    }
}
