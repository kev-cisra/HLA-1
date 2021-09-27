<template>
    <span>{{x}}, {{y}}</span>
    <canvas id="myCanvas" width="560" height="360" @mousedown="beginDrawing" @mousemove="keepDrawing" @mouseup="stopDrawing" />
</template>

<style>
    #myCanvas {
    border: 1px solid grey;
    cursor: crosshair;
    }
</style>
<script>

export default {
    data: function () {
        return {
            x: 0,
            y: 0,
            isDrawing: false,
            canvas: null,
        }
    },
    mounted() {
        var c = document.getElementById("myCanvas");
        this.canvas = c.getContext('2d');
    },
    methods: {
        ClearCanvas(){
            var c = document.getElementById("myCanvas");
            this.canvas.clearRect(0, 0, c.width, c.height);
        },
        GuardarCanvas(){
            console.log("Guardar Canvas");
            var c = document.getElementById("myCanvas");
            var dataUrl = c.toDataURL();
            // drawImage.setAttribute("src", dataUrl);
            console.log(dataUrl);
        },
        drawLine(x1, y1, x2, y2) {
            let ctx = this.canvas;
            ctx.beginPath();
            ctx.strokeStyle = 'black';
            ctx.lineWidth = 2;
            ctx.moveTo(x1, y1);
            ctx.lineTo(x2, y2);
            ctx.stroke();
            ctx.closePath();
        },

        beginDrawing(e) {
            this.x = e.offsetX;
            this.y = e.offsetY;
            this.isDrawing = true;
        },

        keepDrawing(e) {
            if (this.isDrawing === true) {
                this.drawLine(this.x, this.y, e.offsetX, e.offsetY);
                this.x = e.offsetX;
                this.y = e.offsetY;
            }
        },

        stopDrawing(e) {
            if (this.isDrawing === true) {
                this.drawLine(this.x, this.y, e.offsetX, e.offsetY);
                this.x = 0;
                this.y = 0;
                this.isDrawing = false;
            }
        }
    },
}
</script>
