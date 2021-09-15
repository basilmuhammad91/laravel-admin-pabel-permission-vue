<template>
	<div class="text-center" v-if="loading">
        <b-spinner label="text-center" variant="info" class="mt-5 mb-5" style="width: 5rem; height: 5rem; "></b-spinner>
      </div>
</template>

<script type="text/javascript">
	export default{
		props: {
			loading: Boolean
		}
	}
</script>