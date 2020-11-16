
<template>
    <select :name="name" class="form-control">
        <option value="0">Select User Assigned</option>
        <option v-for="user in users" :value="user.id">{{ user.name }}</option>
    </select> 
 
</template>

<script>

export default {
  props: ['name'],      
  data () {
    return {
       users: []
    }
  },
  created() {
      axios.get('/get-users/').then((response) => {console.log(response); this.users = response.data.users;});
  }
}
</script>