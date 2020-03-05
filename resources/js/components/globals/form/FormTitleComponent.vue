<template>
    <div>
        <div class="horizontal-line-wrapper mb-2">
            <h6>{{formTitle}}</h6>
        </div>
        <div class="clearfix"></div>
        
    </div>
</template>

<script>

export default {
  // mounted() {
  //     console.log('Component mounted.')
  // }
  props: {
      formTitle : '',
  },
  data() {
    return {
      
    };
  }
};
</script>