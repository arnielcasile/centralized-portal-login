
class usingDefaultPasword{

    constructor(store)
    {
        this.store = store;
    }

    checkDefaultPassword(){
       
        let localStoragePCheck = localStorage.getItem("pcheck");
        console.log(localStoragePCheck);
        if(JSON.parse(localStoragePCheck))
        {
            this.store.dispatch('showChangePassword',{
                variant: "primary",
            });
        }
    }
}

module.exports = usingDefaultPasword