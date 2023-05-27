<template>
    <div v-if="attachment?.id">
        <img :src="attachment.attributes.url" width="150" height="100" alt="" v-if="attachment.attributes.type === 'image'">
        <audio controls v-if="attachment.attributes.type === 'audio'">
            <source :src="attachment.attributes.url" type="audio/ogg">
            <source :src="attachment.attributes.url" type="audio/mpeg">
            Your browser does not support the audio tag.
        </audio>
    </div>
</template>
<script>
export default {
    props : ["attachment"],
    name: "attachment"
}
</script>
