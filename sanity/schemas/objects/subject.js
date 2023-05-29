export default {
    name: 'subjects',
    title: 'Subjects',
    type: 'object',
    fields: [
        {
            name: 'image',
            title: 'Image',
            type: 'image',
            options: {
                hotspot: true,
            },
        },
        {
            name: 'outline',
            title: 'Subject Outline',
            type: 'array',
            of: [{type: 'outline'}],
        },
        {
            name: 'title',
            title: 'Title',
            type: 'string',
        },
        {
            name: 'startDate',
            title: 'Start Date',
            type: 'datetime',
        },
        {
            name: 'grade',
            title: 'Grade',
            type: 'number',
        },
        {
            name: 'teacher',
            title: 'Teacher',
            type: 'string',
        },
    ],
}
