import {DataService} from "./DataService.js";

class Filter extends DataService {

    constructor() {
        super("admin");
    }

    async filterEmployees(filter, filterValue) {
        return await this.sendRequest(
            "filterEmployees",
            "POST",
            200,
            {
                filter: filter,
                filterValue: filterValue
            },
            []
        );
    }

    async filterStatistics(date, employeeId) {
        return await this.sendRequest(
            "filterStatistics",
            "POST",
            200,
            {
                date: date,
                employeeId: employeeId
            },
            []
        );
    }
}

export {Filter}