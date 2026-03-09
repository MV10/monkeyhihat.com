<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Monkey Hi Hat</title>
<base href="https://www.monkeyhihat.com/">
<link rel="icon" type="image/png" href="/icons/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="/icons/favicon.svg" />
<link rel="shortcut icon" href="/icons/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="/icons/apple-touch-icon.png" />
<meta name="apple-mobile-web-app-title" content="MonkeyHiHat" />
<link rel="manifest" href="/icons/site.webmanifest" />
<meta property="og:title" content="Monkey Hi Hat">
<meta property="og:description" content="The best 100% free music visualizer for Windows and Linux PCs">
<meta property="og:image" content="https://www.monkeyhihat.com/icons/preview.png">
<meta property="og:url" content="https://www.monkeyhihat.com/">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Monkey Hi Hat">
<meta name="twitter:description" content="The best 100% free music visualizer for Windows and Linux PCs">
<meta name="twitter:image" content="https://www.monkeyhihat.com/icons/preview.png">
<style>
html,body{
    margin:0;
    height:100%;
    overflow:hidden;
    background:#000;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", Arial, sans-serif;
}
canvas{display:block;width:100vw;height:100vh}
.content{
    position:fixed;
    inset:0;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    pointer-events:none;
    padding-top:8vh;
    padding-bottom:14vh;  /* reserves safe space for footer */
    box-sizing:border-box;
    gap:1.5vh;
}
#logo{
width:22vw;
max-width:320px;
height:auto;
border-radius:50%;
overflow:hidden;
border:6px solid rgba(255,255,255,0.2);
box-shadow:0 0 60px rgba(255,255,255,0.6);
flex-shrink:0;
}
#title{
margin:0;
font-size:clamp(2.5rem, 7.5vw, 7rem);
font-weight:900;
color:#fff;
text-shadow:0 0 40px rgba(255,255,255,0.9);
-webkit-text-stroke:5px rgba(0,0,0,0.85);
paint-order:stroke fill;
flex-shrink:0;
line-height:1;
}
#subtitle{
margin:0;
font-size:clamp(1rem, 2.8vw, 2.4rem);
font-weight:700;
max-width:90vw;
text-align:center;
color:rgba(255,255,255,0.35);
-webkit-text-stroke:2px rgba(0,0,0,0.9);
-webkit-text-fill-color:rgba(255,255,255,0.35);
paint-order:stroke fill;
flex-shrink:0;
}
.footer{
    position:fixed;
    bottom:2vh;
    left:50%;
    transform:translateX(-50%);
    display:flex;
    flex-direction:row;
    gap:2.5rem;
    align-items:flex-end;
    pointer-events:none;
}
.footer-item{
    display:flex;
    flex-direction:column;
    align-items:center;
}
.footer-icon{
    width:56px;
    height:56px;
    pointer-events:all;
    opacity:0.8;
    transition:opacity .3s;
    filter:drop-shadow(0 0 6px #000);
    display:block;
}
.footer-icon:hover{opacity:1}
.footer-label{
    margin-top:4px;
    font-size:0.9rem;
    font-weight:700;
    color:#000;
    text-shadow:-1px -1px 0 #fff,1px -1px 0 #fff,-1px 1px 0 #fff,1px 1px 0 #fff;
    white-space:nowrap;
}
</style>
</head>
<body>

<canvas id="c"></canvas>
<div class="content">
<img id="logo" src="volt.png">
<div id="title">Monkey Hi Hat</div>
<div id="subtitle">The best 100% free music visualizer for Windows and Linux PCs</div>
</div>

<div class="footer">

<div class="footer-item">
<a class="footer-icon" href="https://github.com/MV10/monkey-hi-hat" target="_blank" rel="noopener">
<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
<polyline points="14 2 14 8 20 8"/>
<line x1="16" y1="13" x2="8" y2="13"/>
<line x1="16" y1="17" x2="8" y2="17"/>
<line x1="10" y1="9" x2="8" y2="9"/>
</svg>
</a>
<div class="footer-label">README</div>
</div>

<div class="footer-item">
<a class="footer-icon" href="https://github.com/MV10/monkey-hi-hat/releases" target="_blank" rel="noopener">
<svg viewBox="0 0 98 96" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M48.854 0C21.839 0 0 22 0 49.217c0 21.756 13.993 40.172 33.405 46.69 2.427.49 3.316-1.059 3.316-2.362 0-1.141-.08-5.052-.08-9.127-13.59 2.934-16.42-5.867-16.42-5.867-2.184-5.704-5.42-7.17-5.42-7.17-4.448-3.015.324-3.015.324-3.015 4.934.326 7.523 5.052 7.523 5.052 4.367 7.496 11.404 5.378 14.235 4.074.404-3.178 1.699-5.378 3.074-6.6-10.839-1.141-22.243-5.378-22.243-24.283 0-5.378 1.94-9.778 5.014-13.2-.485-1.222-2.184-6.275.486-13.038 0 0 4.125-1.304 13.426 5.052a46.97 46.97 0 0 1 12.214-1.63c4.125 0 8.33.571 12.213 1.63 9.302-6.356 13.427-5.052 13.427-5.052 2.67 6.763.97 11.816.485 13.038 3.155 3.422 5.015 7.822 5.015 13.2 0 18.905-11.404 23.06-22.324 24.283 1.78 1.548 3.316 4.481 3.316 9.126 0 6.6-.08 11.897-.08 13.038 0 1.304.89 2.853 3.316 2.362 19.412-6.52 33.405-24.935 33.405-46.691C97.707 22 75.788 0 48.854 0z" fill="#fff"/>
</svg>
</a>
<div class="footer-label">Install it now!</div>
</div>

<div class="footer-item">
<a class="footer-icon" href="https://www.monkeyhihat.com/docs/index.php#/introduction">
<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
<path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
<line x1="9" y1="7" x2="15" y2="7"/>
<line x1="9" y1="11" x2="15" y2="11"/>
<line x1="9" y1="15" x2="12" y2="15"/>
</svg>
</a>
<div class="footer-label">Documentation</div>
</div>

</div>

<script>
const canvas = document.getElementById('c');
const gl = canvas.getContext('webgl', {alpha:false});
if (!gl) throw 'WebGL failed';

// Timing constants (in seconds)
const RUN_DURATION = 10.0;
const FADE_DURATION = 0.5;

function resize() {
    canvas.width = canvas.offsetWidth;
    canvas.height = canvas.offsetHeight;
    gl.viewport(0,0,canvas.width,canvas.height);
}
resize();
window.addEventListener('resize', resize);

const vs = "attribute vec2 p;void main(){gl_Position=vec4(p,0,1);}";

const shaders = [

    // Plasma Wave - based on "distort wave" by zl1fromhell (https://www.shadertoy.com/view/MXlXzl)
    `
    precision highp float;
    uniform vec3 iResolution;
    uniform float iTime;
    uniform float fadeLevel;

    void mainImage(out vec4 c, in vec2 f){
        vec2 p = (2.0 * f - iResolution.xy) / min(iResolution.x, iResolution.y);
        float t = 0.6;
        p = vec2(cos(t) * p.x - sin(t) * p.y, sin(t) * p.x + cos(t) * p.y);
        for(float i = 1.0; i < 100.0; i++){
            p.x += 0.7 / i * sin(i * 0.2 + p.y + iTime * 0.2);
            p.y += 0.5 / i * cos(i * 4.0 * p.x + iTime * -0.6);
        }
        float r = (cos(p.x + p.y + 1.0)) * 0.5 + 0.5;
        float g = abs(sin(p.x + p.y + 1.0));
        float b = 0.5 + 0.5 * ((sin(p.x + p.y) + cos(p.x + p.y)) * 0.8);
        c = vec4(r * fadeLevel, g * fadeLevel, b * fadeLevel, 1.0);
    }
    void main(){mainImage(gl_FragColor, gl_FragCoord.xy);}
    `,

// Lava Lamp - based on "tm gyroids" by tubeman (https://www.shadertoy.com/view/l3fSDr)
`
precision highp float;
uniform vec3 iResolution;
uniform float iTime;
uniform float fadeLevel;

vec3 pal(float t){
    vec3 b = vec3(0.45);
    vec3 c = vec3(0.35);
    return b + c*cos(6.28318*(t*vec3(1.0)+vec3(0.7,0.39,0.2)));
}

float gyroid(vec3 p, float scale){
    p *= scale;
    float bias = mix(1.1, 2.65, sin(iTime*0.4 + p.x/3.0 + p.z/4.0)*0.5+0.5);
    float g = abs(dot(sin(p*1.01), cos(p.zxy*1.61)) - bias)/(scale*1.5)-0.1;
    return g;
}

float scene(vec3 p){
    return 0.7*gyroid(p, 4.0);
}

vec3 norm(vec3 p){
    const vec2 e = vec2(0.01, -0.01);
    return normalize(vec3(
        scene(p+e.xyy) - scene(p-e.xyy),
                          scene(p+e.yxy) - scene(p-e.yxy),
                          scene(p+e.yyx) - scene(p-e.yyx)
    ));
}

void mainImage(out vec4 fragColor, in vec2 fragCoord){
    vec2 uv = (fragCoord-0.5*iResolution.xy)/iResolution.y;
    vec3 ro = vec3(iTime*0.25,1.5,0.3);
    vec3 rd = normalize(vec3(1.0, uv));

    vec3 p = ro;
    bool hit = false;
    float t = 0.0;
    for(int i=0; i<100; i++){
        float d = scene(p);
        if(d < 0.0001){
            hit = true;
            break;
        }
        if(t > 8.0) break;
        t += d;
        p = ro + rd*t;
    }

    vec3 n = norm(p);

    float ao = 1.0 - smoothstep(-0.3,0.75,scene(p+n*0.4)) *
    smoothstep(-3.0,3.0,scene(p+n*1.0));
    float fres = -max(0.0, pow(0.8-abs(dot(rd,n)), 3.0));
    vec3 vign = smoothstep(0.0,1.0,vec3(1.0-(length(uv*0.8)-0.1)));
    vec3 col = pal(0.1-iTime*0.01 + p.x*0.28 + p.y*0.2 + p.z*0.2);
    col = (vec3(fres)+col)*ao;
    col = mix(col, vec3(0.0), hit ? 0.0 : 1.0);
    col = mix(vec3(0.0),col, vign+0.1);
    col = smoothstep(0.0,1.0+0.3*sin(iTime+p.x*4.0+p.z*4.0),col);
    fragColor = vec4(sqrt(col) * fadeLevel, 1.0);
}
void main(){mainImage(gl_FragColor, gl_FragCoord.xy);}
`,

// Snap - based on "GIT" by Antonalog (https://www.shadertoy.com/view/Mdj3RV)
`
precision highp float;
uniform vec3 iResolution;
uniform float iTime;
uniform float fadeLevel;

float hash( float n )
{
    return fract(sin(n)*43758.5453);
}

float noise( in vec3 x )
{
    vec3 p = floor(x);
    vec3 f = fract(x);

    f = f*f*(3.0-2.0*f);
    float n = p.x + p.y*57.0 + 113.0*p.z;
    return mix(mix(mix( hash(n+  0.0), hash(n+  1.0),f.x),
                   mix( hash(n+ 57.0), hash(n+ 58.0),f.x),f.y),
               mix(mix( hash(n+113.0), hash(n+114.0),f.x),
                   mix( hash(n+170.0), hash(n+171.0),f.x),f.y),f.z);
}

vec3 noise3( in vec3 x)
{
    return vec3( noise(x+vec3(123.456,.567,.37)),
                 noise(x+vec3(.11,47.43,19.17)),
                 noise(x) );
}

float bias(float x, float b) {
    return  x/((1./b-2.)*(1.-x)+1.);
}

float gain(float x, float g) {
    float t = (1./g-2.)*(1.-(2.*x));
    return x<0.5 ? (x/(t+1.)) : (t-x)/(t-1.);
}

mat3 rotation(float angle, vec3 axis)
{
    float s = sin(-angle);
    float c = cos(-angle);
    float oc = 1.0 - c;
    vec3 sa = axis * s;
    vec3 oca = axis * oc;
    return mat3(
        oca.x * axis + vec3(	c,	-sa.z,	sa.y),
                oca.y * axis + vec3( sa.z,	c,		-sa.x),
                oca.z * axis + vec3(-sa.y,	sa.x,	c));
}

vec3 fbm(vec3 x, float H, float L, int oc)
{
    vec3 v = vec3(0);
    float f = 1.;
    for (int i=0; i<10; i++)
    {
        if (i >= oc) break;
        float w = pow(f,-H);
        v += noise3(x)*w;
        x *= L;
        f *= L;
    }
    return v;
}

vec3 smf(vec3 x, float H, float L, int oc, float off)
{
    vec3 v = vec3(1);
    float f = 1.;
    for (int i=0; i<10; i++)
    {
        if (i >= oc) break;
        v *= off + f*(noise3(x)*2.-1.);
        f *= H;
        x *= L;
    }
    return v;
}

vec3 rgb2hsv(vec3 c)
{
    vec4 K = vec4(0.0, -1.0/3.0, 2.0/3.0, -1.0);
    vec4 p = c.g < c.b ? vec4(c.bg, K.wz) : vec4(c.gb, K.xy);
    vec4 q = c.r < p.x ? vec4(p.xyw, c.r) : vec4(c.r, p.yzx);
    float d = q.x - min(q.w, q.y);
    float e = 1.0e-10;
    return vec3(abs(q.z + (q.w - q.y)/(6.0*d + e)),
                d/(q.x + e),
                q.x);
}

vec3 hsv2rgb(vec3 c)
{
    vec4 K = vec4(1.0, 2.0/3.0, 1.0/3.0, 3.0);
    vec3 p = abs(fract(c.xxx + K.xyz)*6.0 - K.www);
    return c.z * mix(K.xxx, clamp(p - K.xxx, 0.0, 1.0), c.y);
}

void mainImage(out vec4 fragColor, in vec2 fragCoord)
{
    vec2 uv = fragCoord.xy / iResolution.xy;
    uv.x *= iResolution.x / iResolution.y;

    float time = iTime * 1.276;
    float slow = time * 0.002;
    uv *= 1.0 + 0.5 * slow * sin(slow * 10.0);

    float ts = time * 0.37;
    float change = gain(fract(ts), 0.0008) + floor(ts);

    vec3 p = vec3(uv * 0.2, slow + change);

    vec3 axis = 4.0 * fbm(p, 0.5, 2.0, 8);

    vec3 colorVec = 0.5 + 5.0 * fbm(p * 0.3, 0.5, 2.0, 7);
    p += colorVec;

    float mag = 0.75e5;
    vec3 colorMod = mag * smf(p, 0.7, 2.0, 8, 0.2);

    colorVec += colorMod;

    colorVec = rotation(3.0 * length(axis) + slow * 10.0, normalize(axis)) * colorVec;

    colorVec *= 0.05;

    /* Counteract the extreme compression of smf while keeping every detail */
    colorVec = colorVec / (1.0 + 0.00085 * length(colorMod));

    /* Vivid but natural color enhancement in HSV space */
    vec3 hsv = rgb2hsv(colorVec);
    hsv.y = pow(hsv.y, 0.45);    // strong saturation boost
    hsv.z = pow(hsv.z, 0.80);    // gentle contrast
    colorVec = hsv2rgb(hsv);

    colorVec *= 1.32;            // final exposure

    colorVec = pow(colorVec, vec3(1.0 / 2.2));

    fragColor = vec4(colorVec * fadeLevel, 1.0);
}

void main(){mainImage(gl_FragColor, gl_FragCoord.xy);}
`
];

// Compile all shader programs
function createProgram(fs) {
    const prog = gl.createProgram();
    [gl.VERTEX_SHADER, gl.FRAGMENT_SHADER].forEach((t, i) => {
        const s = gl.createShader(t);
        gl.shaderSource(s, i ? fs : vs);
        gl.compileShader(s);
        gl.attachShader(prog, s);
    });
    gl.linkProgram(prog);
    return {
        program: prog,
        uRes: gl.getUniformLocation(prog, 'iResolution'),
        uTime: gl.getUniformLocation(prog, 'iTime'),
        uFade: gl.getUniformLocation(prog, 'fadeLevel')
    };
}

const programs = shaders.map(createProgram);

// Set up geometry (shared by all programs)
gl.bindBuffer(gl.ARRAY_BUFFER, gl.createBuffer());
gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([-1,-1,3,-1,-1,3]), gl.STATIC_DRAW);
gl.enableVertexAttribArray(0);
gl.vertexAttribPointer(0,2,gl.FLOAT,false,0,0);

// State
let currentIndex = Math.floor(Math.random() * shaders.length);
let cycleStart = performance.now();
let shaderStart = performance.now();

// Transition states: 'visible', 'fading_out', 'fading_in'
let transitionState = 'fading_in';
let transitionStart = performance.now();

function render() {
    resize();
    const now = performance.now();
    const shaderTime = (now - shaderStart) * 0.001;
    const cycleTime = (now - cycleStart) * 0.001;

    // Calculate fade level based on transition state
    let fadeLevel = 1.0;
    const transitionElapsed = (now - transitionStart) * 0.001;

    if (transitionState === 'fading_in') {
        fadeLevel = Math.min(transitionElapsed / FADE_DURATION, 1.0);
        if (fadeLevel >= 1.0) {
            transitionState = 'visible';
        }
    } else if (transitionState === 'fading_out') {
        fadeLevel = Math.max(1.0 - transitionElapsed / FADE_DURATION, 0.0);
        if (fadeLevel <= 0.0) {
            // Switch to next shader
            currentIndex = (currentIndex + 1) % shaders.length;
            shaderStart = now;
            cycleStart = now;
            transitionState = 'fading_in';
            transitionStart = now;
            fadeLevel = 0.0;
        }
    } else if (transitionState === 'visible') {
        // Check if it's time to start fading out
        if (cycleTime >= RUN_DURATION) {
            transitionState = 'fading_out';
            transitionStart = now;
        }
    }

    const prog = programs[currentIndex];
    gl.useProgram(prog.program);
    gl.uniform3f(prog.uRes, canvas.width, canvas.height, 1);
    gl.uniform1f(prog.uTime, shaderTime);
    gl.uniform1f(prog.uFade, fadeLevel);

    gl.clearColor(0,0,0,1);
    gl.clear(gl.COLOR_BUFFER_BIT);
    gl.drawArrays(gl.TRIANGLES, 0, 3);
    requestAnimationFrame(render);
}

render();
</script>
</body>
</html>
