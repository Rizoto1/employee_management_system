import {DataService} from "./DataService.js";

class Filter extends DataService {

    constructor() {
        super("admin");
    }

    async filterEmployees(filter, filterValue) {
        return await this.sendRequest(
            "filter",
            "POST",
            200,
            {
                filter: filter,
                filterValue: filterValue
            },
            []
        );
    }
}

export {Filter}