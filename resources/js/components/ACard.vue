<template>
    <div>
        <b-card class="system_card position-relative"> 
             <div class="system_card_inner_circle"></div>
             <div class="system_card_outer_circle"></div>
             <div class="system_card_inner_square"></div>
             <div class="system_card_outer_square"></div>
             <!-- <img :src="'images/laptop.png'" class="system_card__image" /> -->

            <b-card-text class="position-relative" style=" height: 250px;">
                <div class="card-text-title">
                    <div class="card-text-title-icon text-left">
                       <svg id="Component_2_1" data-name="Component 2 – 1" xmlns="http://www.w3.org/2000/svg" width="79.414" height="49.475" viewBox="0 0 79.414 49.475">
                        <g id="laptop_chromebook-24px" transform="translate(0 13)">
                            <path id="Path_8" data-name="Path 8" d="M0,0H41.5V36.475H0Z" fill="none"/>
                            <path id="Path_9" data-name="Path 9" d="M38.042,29.008V3H3.458V29.008H0v3.468H41.5V29.008Zm-13.833,0H17.292V27.274h6.917Zm10.375-5.2H6.917V6.468H34.583Z" fill="#eef2f3"/>
                        </g>
                        <g id="settings-24px" transform="translate(32)">
                            <path id="Path_10" data-name="Path 10" d="M0,0H19.334V18H0Z" fill="none"/>
                            <path id="Path_11" data-name="Path 11" d="M15.023,9.646A4.463,4.463,0,0,0,15.068,9a3.647,3.647,0,0,0-.053-.646l1.523-1.086a.319.319,0,0,0,.09-.419l-1.44-2.282a.382.382,0,0,0-.443-.151l-1.793.66a5.434,5.434,0,0,0-1.215-.646l-.27-1.746a.355.355,0,0,0-.36-.282H8.227a.347.347,0,0,0-.353.282L7.6,4.428a5.553,5.553,0,0,0-1.215.646L4.6,4.414a.373.373,0,0,0-.443.151L2.721,6.848a.3.3,0,0,0,.09.419L4.333,8.354a3.51,3.51,0,0,0-.015,1.292L2.8,10.733a.319.319,0,0,0-.09.419l1.44,2.282a.382.382,0,0,0,.443.151l1.793-.66a5.434,5.434,0,0,0,1.215.646l.27,1.746a.361.361,0,0,0,.36.282h2.881a.341.341,0,0,0,.353-.282l.27-1.746a5.275,5.275,0,0,0,1.215-.646l1.793.66a.373.373,0,0,0,.443-.151l1.44-2.283a.3.3,0,0,0-.09-.419ZM9.667,11.475A2.6,2.6,0,0,1,6.966,9a2.6,2.6,0,0,1,2.7-2.475A2.6,2.6,0,0,1,12.367,9,2.6,2.6,0,0,1,9.667,11.475Z" fill="#eef2f3"/>
                        </g>
                        <g id="settings-24px-2" data-name="settings-24px" transform="matrix(0.809, 0.588, -0.588, 0.809, 56.856, 0.468)">
                            <path id="Path_10-2" data-name="Path 10" d="M0,0H27.883V27.881H0Z" fill="none"/>
                            <path id="Path_11-2" data-name="Path 11" d="M22.566,15.07a8.464,8.464,0,0,0,.072-1.13,6.912,6.912,0,0,0-.085-1.13l2.452-1.9a.588.588,0,0,0,.145-.733L22.831,6.187a.591.591,0,0,0-.713-.264L19.232,7.076a8.543,8.543,0,0,0-1.957-1.13L16.84,2.893a.584.584,0,0,0-.58-.493H11.622a.571.571,0,0,0-.568.493L10.62,5.946a8.731,8.731,0,0,0-1.957,1.13L5.776,5.922a.578.578,0,0,0-.713.264L2.756,10.178a.545.545,0,0,0,.145.733l2.452,1.9a6.656,6.656,0,0,0-.024,2.26l-2.452,1.9a.588.588,0,0,0-.145.733l2.319,3.991a.591.591,0,0,0,.713.264L8.651,20.8a8.543,8.543,0,0,0,1.957,1.13l.435,3.053a.593.593,0,0,0,.58.493H16.26a.562.562,0,0,0,.568-.493l.435-3.053A8.294,8.294,0,0,0,19.22,20.8l2.887,1.154a.578.578,0,0,0,.713-.264L25.138,17.7a.555.555,0,0,0-.145-.733Zm-8.624,3.2A4.328,4.328,0,1,1,18.29,13.94,4.351,4.351,0,0,1,13.941,18.268Z" transform="translate(0 0)" fill="#eef2f3"/>
                        </g>
                        </svg>
                    </div>
                    <div class="text-left">
                        {{system_data.name}}
                    </div>
                    
                </div>
                <span class="line-white"></span>
                <div class="card-text-details text-left mt-2">
                       {{system_data.description}}
                
                </div>
               
               
            </b-card-text>

                <div class="card-text-controls">
                    
                    <b-button variant="danger" class="card-text-btn" v-b-modal="'system_launch_'+ system_data.id">SYSTEM DETAILS</b-button>
                    <!-- <b-button variant="danger" class="card-text-btn">CONTACT US</b-button> -->
                </div>
        </b-card>
          

        <b-modal :id="'system_launch_' + system_data.id" :title="system_data.name" hide-footer centered
        header-bg-variant="dark"
        header-text-variant="light"
        body-bg-variant="light"
        body-text-variant="dark"
        footer-bg-variant="dark"
        footer-text-variant="light">
        <img :src="'images/pc_laptop.svg'" style="height: 200px; position: relative; left: 15%; margin-top: 15%;"  />
            <div class="mt-4">
                <b-row>
                    <b-col cols="5" class="border-right">Abbreviation:</b-col>
                    <b-col cols="7">{{system_data.abbreviation}}</b-col>
                    <b-col cols="5" class="border-right">Reference Code:</b-col>
                    <b-col cols="7">{{system_data.reference_code}}</b-col>
                    <b-col cols="5" class="border-right">Reference Number:</b-col>
                    <b-col cols="7">{{system_data.reference_number}}</b-col>
                    <b-col cols="5" class="border-right">Date Deployed:</b-col>
                    <b-col cols="7">{{system_data.date_deployed}}</b-col>
                    <b-col cols="5" class="border-right">Section Owner:</b-col>
                    <b-col cols="7">{{system_data.section_owner}}</b-col>
                    <b-col cols="5" class="border-right">Description:</b-col>
                    <b-col cols="7">{{system_data.description}}</b-col>
                </b-row>
            </div>
            <!-- <button class="card-text-btn" @click="system_launch">LAUNCH SYSTEM</button> -->
            <b-button variant="dark" class="float-right" @click="system_launch" size="sm">LAUNCH SYSTEM</b-button>
        </b-modal>

    </div>
</template>


<script>
export default {
    name: "ACard",
    props:{
        system_data : Object
    },
    methods: {
        system_launch(){
            let user_data = JSON.parse(localStorage.getItem("userdata"));
            let auth_token = user_data.data.data.auth_token.auth_token;
            let system_path = this.system_data.url;
            let last_char = system_path[system_path.length -1];
            (last_char === '/') ?  system_path = system_path + auth_token :  system_path = system_path + '/'+ auth_token;
            console.log(last_char);
            window.open(system_path, "_blank");
        }
    }
}
</script>

<style lang="scss">
    @import "../../sass/variables";
    @import "../../sass/mediascreens";
    .line-white{
        background: white;
        height: 2px;
        // width: 120%;
        position: absolute;
        left: 0%;
        animation: line_slide 0.7s;
        animation-fill-mode: forwards;
        animation-delay: 0.1s;
    }
    .card-text-title
    {
        font-size: 20px;
        position: relative;
        font-weight: bold;
        // border: solid 3px black;
        height: 120px;
    }
    
    .card-text-details
    {
        font-size: 15px;
    }

    .card-text-btn{
            background: #ffffff45;
            color: white;
            border: 0;
            padding: 5px 20px 5px 20px;
            outline: none;
            font-size: 15px;
            font-family: MontserratLight;
            transition: ease 1s;
            opacity: 0;
            animation: fadeIn 1s;
            animation-fill-mode: forwards;
            animation-delay: 0.4s;
            box-shadow: 0 0 3px rgb(230, 230, 230);
            width: 170px;
            margin: 5px;
    }

    
    .card-text-controls
    {
        text-align: left;
        position: relative;
        bottom:30%;

        
    }

    .system_card{
        background-color: $prime;
        color: $white;
        overflow: hidden;
        margin-bottom: 20px;
        height: 280px;
         
    }

    .system_card_inner_circle{
        border-radius: 50%;
        height: 200px;
        width: 200px;
        position: absolute;
        left: 75%;
        top: -50%;
        background-color: rgba(255, 255, 255, 0.1);
        transition: ease-in-out 1s;
    }

    .system_card_outer_circle{
        border-radius: 50%;
        height: 300px;
        width: 300px;
        position: absolute;
        left: 60%;
        top: -80%;
        background-color: rgba(255, 255, 255, 0.1);
        transition: ease-in-out 1s;
    }
    .system_card_inner_square{
        border-radius: 10%;
        height: 300px;
        width: 300px;
        position: absolute;
        left: -50%;
        bottom: -120%;
        background-color: rgba(255, 255, 255, 0.1);
        transition: ease-in-out 1s;
    }
    .system_card_outer_square{
        border-radius: 10%;
        height: 300px;
        width: 300px;
        position: absolute;
        left: -40%;
        bottom: -100%;
        background-color: rgba(255, 255, 255, 0.1);
        transition: ease-in-out 1s;
    }

    .system_card__image{
        width: 150px;
        position: absolute;
        opacity: 0.9;
    }

.modal-header
{
    border-bottom: 3px solid $prime;
}


    // Small devices (landscape phones, 576px and up)
    @media (min-width: 576px) {
        .system_card_inner_circle{
            left: 80%;
            top: -30%;
        }
        .system_card_outer_circle{
            left: 72%;
            top: -45%;
        }
        .system_card_inner_square{
            left: -25%;
            bottom: -90%;
        }
        .system_card_outer_square{
            left: -15%;
            bottom: -70%;
        }
        .system_card__image{
             right: 6%;
             top: 40%;
        }
        .system_card{
            margin-bottom: 20px;
            height: 280px;
         
        }
    }

    // Medium devices (tablets, 768px and up)
    @media (min-width: 768px) { 
        .system_card_inner_circle{
            left: 87%;
            top: -30%;
        }

        .system_card_outer_circle{
            left: 80%;
            top: -40%;
        }

        .system_card_inner_square{
            left: -20%;
            bottom: -65%;
        }
        
        .system_card_outer_square{
            left: -15%;
            bottom: -50%;
        }
        
     }

    // Large devices (desktops, 992px and up)
    @media (min-width: 992px) {  
        .card-text-title
        {
            height: 150px;
        }

        .card-text-controls
        {
            text-align: center;
            bottom:2%;
        }
        .line-white{
            position: absolute;
            left: 0%;
            top: 60%;
        }

        .system_card_inner_circle{
            left: 80%;
            top: -30%;
        }

        .system_card_outer_circle{
            left: 65%;
            top: -45%;
        }

        .system_card_inner_square{
            left: -50%;
            bottom: -65%;
        }

        .system_card_outer_square{
            left: -35%;
            bottom: -50%;
        }

        .system_card{
            height: 380px;
        }

    }

    // X-Large devices (large desktops, 1200px and up)
    @media (min-width: 1200px) {  
         .system_card_inner_square{
            left: -70%;
            bottom: -65%;
        }
        .system_card_outer_square{
            left: -55%;
            bottom: -50%;
        }
    }

    // XX-Large devices (larger desktops, 1400px and up)
    @media (min-width: 1400px) {
        .card-text-title
        {
            height: 120px;
        }
        .card-text-controls
        {
            bottom:20%;
        }

        .line-white{
            position: absolute;
            left: 0%;
            top: 48%;
        }

        .system_card_inner_square{
            left: -40%;
            bottom: -70%;
        }

        .system_card_outer_square{
            left: -30%;
            bottom: -55%;
        }

        .system_card{
            height: 300px;
        }
        
      }

</style>