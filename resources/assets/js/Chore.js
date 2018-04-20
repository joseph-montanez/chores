export default class Chore {
    constructor(data = {}, workers = []) {
        let defaultTimezone = "America/Los_Angeles";

        this.id = data.id ? data.id : 0;
        this.user_id = data.user_id ? data.user_id : 0;
        this.distribution = data.distribution ? data.distribution : 'random';
        this.name = data.name ? data.name : '';
        this.description = data.description ? data.description : '';
        this.points = data.points ? data.points : 0;
        this.reoccurring = data.reoccurring ? data.reoccurring : 0;
        this.start_at = data.start_at ? data.start_at : {
            date: new Date(),
            timezone: defaultTimezone,
            timezone_types: 3
        };
        this.start_at_date = data.start_at_date ? data.start_at_date : '';
        this.start_at_time = data.start_at_time ? data.start_at_time : {
            'hh': '00',
            'mm': '00',
            'A': 'AM',
        };
        this.end_at = data.end_at ? data.end_at : {
            date: new Date(),
            timezone: defaultTimezone,
            timezone_types: 3
        };
        this.end_at_date = data.end_at_date ? data.end_at_date : '';
        this.end_at_time = data.end_at_time ? data.end_at_time : {
            'hh': '00',
            'mm': '00',
            'A': 'AM',
        };
        this.timezone = data.timezone ? data.timezone : defaultTimezone;
        this.frequency = data.frequency ? data.frequency : 0;
        this.interval = data.interval ? data.interval : 0;
        this.count = data.count ? data.count : 0;

        this.created_at = data.created_at ? data.created_at : {
            date: new Date(),
            timezone: defaultTimezone,
            timezone_types: 3
        };

        this.updated_at = data.updated_at ? data.updated_at : {
            date: new Date(),
            timezone: defaultTimezone,
            timezone_types: 3
        };

        this.workers = workers ? workers : [];
    }
}

