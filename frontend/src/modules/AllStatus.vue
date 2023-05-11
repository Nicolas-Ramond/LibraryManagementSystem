<template>
  <section class="tg-haslayout">
    <div class="container">
      <div class="row">
        <div class="tg-allstatus">
          <all-status-item/>
          <all-status-item/>
          <all-status-item/>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
  import AllStatusItem from '@/items/allstatus/AllStatusItem'

  export default {
    name: 'AllStatus',
    components: {
      AllStatusItem
    }
  }
</script>
