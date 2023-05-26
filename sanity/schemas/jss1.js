export default {
    name: 'jss1',
    title: 'JSS1',
    type: 'document',
    fields: [
        {
            name: 'title',
            title: 'Title',
            type: 'string'
        },
        {
            name: 'id',
            title: 'ID',
            type: 'string'
        },
        {
            name: 'subjects',
            title: 'Subjects',
            type: 'array',
            options: {
                unique: true,
            },
            of: [{type: 'subjects'}],
        },
        {
            name: 'events',
            title: 'Events',
            type: 'array',
            of: [{type: 'event'}],
        },
    ],
}
