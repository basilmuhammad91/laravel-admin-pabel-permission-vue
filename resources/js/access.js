export default class Access {
    constructor(orgPermission) {
        // this.userRole=JSON.parse(userRole.replace(/&quot;/g,'"'));
        this.orgPermission = JSON.parse(orgPermission.replace(/&quot;/g, '"'));
        // console.log(this.orgPermission);
    }

    can(permissionName) {
        for(const val of this.orgPermission)
        {
            if(val.name == permissionName)
            {
                return 1;
            }
        }
    }

}
