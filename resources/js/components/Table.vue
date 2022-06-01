<template>

    <div class="table-responsive">
         <table   class="table table-striped custom-table" id="example1">
                        <thead>
                        <tr>
                          <th>#</th>
                          <th v-for="field in fields" :key="field">{{field}}</th>
                          <th >Acção</th>
                        </tr>
                        </thead>
                        <tbody>
                           <slot></slot>
                        </tbody>
                    </table>
    </div>
</template>

<script>
export default {
props:{
    fields:Array
},
created() {

},
}
</script>

<style>

</style>
