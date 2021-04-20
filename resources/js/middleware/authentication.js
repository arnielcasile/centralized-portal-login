

class Auth {
    
    constructor(next, router){
        // this.to = to;
        // this.from = from;
        this.next = next;
        this.router = router;
    }

    auth(to, from){
        if (localStorage.getItem("userdata") === null && to.name !== 'login') {
            this.router.push({ name: 'login' });
        }

        this.next();
    }

    guest(){
        if (localStorage.getItem("userdata") !== null) {
            this.router.push({ name: 'Home' });
        }
        this.next();
    }

}

module.exports = Auth