export default {
    name: 'event',
    type: 'object',
    fields: [
        {
            title: 'Title',
            name: 'title',
            type: 'string',
        },
        {
            title: 'Date',
            name: 'date',
            type: 'datetime',
            options: {
                dateFormat: 'DD-MM-YYYY',
                timeFormat: 'HH:mm',
                timeStep: 15,
                calendarTodayLabel: 'Today',
            },
        },
        {
            title: 'Teacher',
            name: 'teacher',
            type: 'string',
        },
    ],
}
