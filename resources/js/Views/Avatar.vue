<template>
    <div class="border font-semibold  p-4 ">
        Password

    </div>

    <div class="p-4 bg-white">

                    <Success  v-if="success" :content="success" @close="success=null" />
                    <errors  v-if="errors" :content="errors"  @close="errors=null" />

                    <form class="md:w-10/12 md:p-4 w-full mx-auto" enctype="multipart/form-data" @submit.prevent="update" >
                        <div class=" w-full my-1 py-2 sm:flex  sm:items-center sm:justify-between">
            <label for="description">Avatar</label>
            <input type="file" name="avatar" class="form-control-file" @change="onFileChange">
                        </div>
                        <div class=" w-full my-1 py-2 sm:flex  sm:items-center  sm:justify-end">
                            <div class="sm:w-8/12 w-full  flex justify-between items-center mt-3 sm:mt-0">
                                 <div v-if="busy"  class="flex justify-center items-center p-2 px-6 rounded-sm text-white bg-blue-500 hover:bg-blue-600">
                                   <circle-svg class="w-6 h-6" />
                                </div>
                                <button v-else type="submit" class="p-3 rounded-sm text-white bg-blue-500 hover:bg-blue-600">Update</button>
                            </div>
                        </div>
                    </form>


    </div>
</template>

<script>
import { XIcon } from '@heroicons/vue/solid';
import Errors from '../components/Errors.vue';
import Success from '../components/Success.vue';
import CircleSvg from '../components/CircleSvg.vue';
export default {
    components : {
        XIcon,
       Errors,
       Success,
        CircleSvg
    },
    data() {
        return {
            avatar: null,
            errors : null,
            success : '',
            busy : false ,
        }
    },


    methods : {
        onFileChange(e){
            this.avatar = e.target.files[0];
        },
        async update(){
            this.busy = true;
            this.errors = null
            this.success = ''
            const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
            try {
                let avatar = new FormData();
                avatar.append('avatar', this.avatar);
                await axios.post('/api/avatar', avatar, config).then(res=>{console.log(res.data)})
                    this.success = 'avatar added successfully'
                    this.busy = false;

            } catch (e) {
                console.log(e.data);
                this.errors = e.data
            }
            this.busy = false ;
        }
    },


}
</script>
