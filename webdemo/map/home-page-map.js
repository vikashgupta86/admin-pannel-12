(function (cjs, an) {

var p; // shortcut to reference prototypes
var lib={};var ss={};var img={};
lib.ssMetadata = [];


(lib.AnMovieClip = function(){
	this.currentSoundStreamInMovieclip;
	this.actionFrames = [];
	this.soundStreamDuration = new Map();
	this.streamSoundSymbolsList = [];

	this.gotoAndPlayForStreamSoundSync = function(positionOrLabel){
		cjs.MovieClip.prototype.gotoAndPlay.call(this,positionOrLabel);
	}
	this.gotoAndPlay = function(positionOrLabel){
		this.clearAllSoundStreams();
		this.startStreamSoundsForTargetedFrame(positionOrLabel);
		cjs.MovieClip.prototype.gotoAndPlay.call(this,positionOrLabel);
	}
	this.play = function(){
		this.clearAllSoundStreams();
		this.startStreamSoundsForTargetedFrame(this.currentFrame);
		cjs.MovieClip.prototype.play.call(this);
	}
	this.gotoAndStop = function(positionOrLabel){
		cjs.MovieClip.prototype.gotoAndStop.call(this,positionOrLabel);
		this.clearAllSoundStreams();
	}
	this.stop = function(){
		cjs.MovieClip.prototype.stop.call(this);
		this.clearAllSoundStreams();
	}
	this.startStreamSoundsForTargetedFrame = function(targetFrame){
		for(var index=0; index<this.streamSoundSymbolsList.length; index++){
			if(index <= targetFrame && this.streamSoundSymbolsList[index] != undefined){
				for(var i=0; i<this.streamSoundSymbolsList[index].length; i++){
					var sound = this.streamSoundSymbolsList[index][i];
					if(sound.endFrame > targetFrame){
						var targetPosition = Math.abs((((targetFrame - sound.startFrame)/lib.properties.fps) * 1000));
						var instance = playSound(sound.id);
						var remainingLoop = 0;
						if(sound.offset){
							targetPosition = targetPosition + sound.offset;
						}
						else if(sound.loop > 1){
							var loop = targetPosition /instance.duration;
							remainingLoop = Math.floor(sound.loop - loop);
							if(targetPosition == 0){ remainingLoop -= 1; }
							targetPosition = targetPosition % instance.duration;
						}
						instance.loop = remainingLoop;
						instance.position = Math.round(targetPosition);
						this.InsertIntoSoundStreamData(instance, sound.startFrame, sound.endFrame, sound.loop , sound.offset);
					}
				}
			}
		}
	}
	this.InsertIntoSoundStreamData = function(soundInstance, startIndex, endIndex, loopValue, offsetValue){ 
 		this.soundStreamDuration.set({instance:soundInstance}, {start: startIndex, end:endIndex, loop:loopValue, offset:offsetValue});
	}
	this.clearAllSoundStreams = function(){
		var keys = this.soundStreamDuration.keys();
		for(var i = 0;i<this.soundStreamDuration.size; i++){
			var key = keys.next().value;
			key.instance.stop();
		}
 		this.soundStreamDuration.clear();
		this.currentSoundStreamInMovieclip = undefined;
	}
	this.stopSoundStreams = function(currentFrame){
		if(this.soundStreamDuration.size > 0){
			var keys = this.soundStreamDuration.keys();
			for(var i = 0; i< this.soundStreamDuration.size ; i++){
				var key = keys.next().value; 
				var value = this.soundStreamDuration.get(key);
				if((value.end) == currentFrame){
					key.instance.stop();
					if(this.currentSoundStreamInMovieclip == key) { this.currentSoundStreamInMovieclip = undefined; }
					this.soundStreamDuration.delete(key);
				}
			}
		}
	}

	this.computeCurrentSoundStreamInstance = function(currentFrame){
		if(this.currentSoundStreamInMovieclip == undefined){
			if(this.soundStreamDuration.size > 0){
				var keys = this.soundStreamDuration.keys();
				var maxDuration = 0;
				for(var i=0;i<this.soundStreamDuration.size;i++){
					var key = keys.next().value;
					var value = this.soundStreamDuration.get(key);
					if(value.end > maxDuration){
						maxDuration = value.end;
						this.currentSoundStreamInMovieclip = key;
					}
				}
			}
		}
	}
	this.getDesiredFrame = function(currentFrame, calculatedDesiredFrame){
		for(var frameIndex in this.actionFrames){
			if((frameIndex > currentFrame) && (frameIndex < calculatedDesiredFrame)){
				return frameIndex;
			}
		}
		return calculatedDesiredFrame;
	}

	this.syncStreamSounds = function(){
		this.stopSoundStreams(this.currentFrame);
		this.computeCurrentSoundStreamInstance(this.currentFrame);
		if(this.currentSoundStreamInMovieclip != undefined){
			var soundInstance = this.currentSoundStreamInMovieclip.instance;
			if(soundInstance.position != 0){
				var soundValue = this.soundStreamDuration.get(this.currentSoundStreamInMovieclip);
				var soundPosition = (soundValue.offset?(soundInstance.position - soundValue.offset): soundInstance.position);
				var calculatedDesiredFrame = (soundValue.start)+((soundPosition/1000) * lib.properties.fps);
				if(soundValue.loop > 1){
					calculatedDesiredFrame +=(((((soundValue.loop - soundInstance.loop -1)*soundInstance.duration)) / 1000) * lib.properties.fps);
				}
				calculatedDesiredFrame = Math.floor(calculatedDesiredFrame);
				var deltaFrame = calculatedDesiredFrame - this.currentFrame;
				if(deltaFrame >= 2){
					this.gotoAndPlayForStreamSoundSync(this.getDesiredFrame(this.currentFrame,calculatedDesiredFrame));
				}
			}
		}
	}
}).prototype = p = new cjs.MovieClip();
// symbols:



(lib.AndhraPradesh = function() {
	this.initialize(img.AndhraPradesh);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,251,245);


(lib.ArunachalPradesh = function() {
	this.initialize(img.ArunachalPradesh);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,150,98);


(lib.Andman11pngcopy2 = function() {
	this.initialize(img.Andman11pngcopy2);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,1200,4094);


(lib.DadraNagarHaveli = function() {
	this.initialize(img.DadraNagarHaveli);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,150,114);


(lib.Assam = function() {
	this.initialize(img.Assam);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,92,32);


(lib.Chandigarh = function() {
	this.initialize(img.Chandigarh);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,288,288);


(lib.delhi = function() {
	this.initialize(img.delhi);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,150,47);


(lib.DamanDiu = function() {
	this.initialize(img.DamanDiu);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,150,150);


(lib.Gujarat = function() {
	this.initialize(img.Gujarat);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,320,150);


(lib.Himachalpngcopy = function() {
	this.initialize(img.Himachalpngcopy);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,282,200);


(lib.haryana = function() {
	this.initialize(img.haryana);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,871,1050);


(lib.Bihar = function() {
	this.initialize(img.Bihar);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,180,217);


(lib.Jharkhandlogo = function() {
	this.initialize(img.Jharkhandlogo);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,225,225);


(lib.Karnataka = function() {
	this.initialize(img.Karnataka);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,351,400);


(lib.Lakshadweep = function() {
	this.initialize(img.Lakshadweep);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,206,210);


(lib.Kerala = function() {
	this.initialize(img.Kerala);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,412,297);


(lib.Maharashtra = function() {
	this.initialize(img.Maharashtra);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,171,243);


(lib.MadhyaPradeshUrjaVikasNigamLimitedlogo = function() {
	this.initialize(img.MadhyaPradeshUrjaVikasNigamLimitedlogo);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,225,225);


(lib.Mizoram = function() {
	this.initialize(img.Mizoram);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,312,244);


(lib.Manipur = function() {
	this.initialize(img.Manipur);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,424,278);


(lib.Nagaland = function() {
	this.initialize(img.Nagaland);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,270,318);


(lib.Odishapngcopy2 = function() {
	this.initialize(img.Odishapngcopy2);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,176,234);


(lib.Meghalaya = function() {
	this.initialize(img.Meghalaya);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,500,500);


(lib.punjab = function() {
	this.initialize(img.punjab);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,200,194);


(lib.RajasthanRenewableEnergyCorporationLtd = function() {
	this.initialize(img.RajasthanRenewableEnergyCorporationLtd);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,512,512);


(lib.Puducherry = function() {
	this.initialize(img.Puducherry);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,306,277);


(lib.PDDlogo = function() {
	this.initialize(img.PDDlogo);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,250,231);


(lib.Sikkim = function() {
	this.initialize(img.Sikkim);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,176,176);


(lib.UttarPradesh = function() {
	this.initialize(img.UttarPradesh);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,117,41);


(lib.Telangana = function() {
	this.initialize(img.Telangana);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,150,149);


(lib.Tripura = function() {
	this.initialize(img.Tripura);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,158,218);


(lib.Chhattisgarh = function() {
	this.initialize(img.Chhattisgarh);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,150,150);


(lib.WestBengal = function() {
	this.initialize(img.WestBengal);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,200,124);


(lib.Uttarakhand = function() {
	this.initialize(img.Uttarakhand);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,150,159);


(lib.Goa = function() {
	this.initialize(img.Goa);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,202,204);// helper functions:

function mc_symbol_clone() {
	var clone = this._cloneProps(new this.constructor(this.mode, this.startPosition, this.loop));
	clone.gotoAndStop(this.currentFrame);
	clone.paused = this.paused;
	clone.framerate = this.framerate;
	return clone;
}

function getMCSymbolPrototype(symbol, nominalBounds, frameBounds) {
	var prototype = cjs.extend(symbol, cjs.MovieClip);
	prototype.clone = mc_symbol_clone;
	prototype.nominalBounds = nominalBounds;
	prototype.frameBounds = frameBounds;
	return prototype;
	}


(lib.text642 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.Symbol1063 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.instance = new lib.Andman11pngcopy2();
	this.instance.setTransform(0,0,0.0451,0.0451);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol1063, new cjs.Rectangle(0,0,54.1,184.6), null);


(lib.Symbol124 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.text = new cjs.Text("Diu", "bold 12px 'Arial'");
	this.text.lineHeight = 14;
	this.text.parent = this;
	this.text.setTransform(39.65,3.2);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#666666").ss(2,1,1).p("AikAAIFJAA");
	this.shape.setTransform(57.325,17.2);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape},{t:this.text}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(37.7,1.2,37.099999999999994,17.7);


(lib.Symbol123 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(0.1,1,1).p("AATABIgIAOIgdAEIAJglIATAKg");
	this.shape.setTransform(120.525,16.25);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#CC6699").s().p("AgJgSIATAKIAJAIIgIAPIgdAEg");
	this.shape_1.setTransform(120.525,16.25);

	this.instance = new lib.DamanDiu();
	this.instance.setTransform(31.7,-4.4,0.1103,0.1103);

	this.text = new cjs.Text("Daman", "bold 12px 'Arial'");
	this.text.lineHeight = 14;
	this.text.parent = this;
	this.text.setTransform(-9.5,2.6);

	this.shape_2 = new cjs.Shape();
	this.shape_2.graphics.f().s("#CC6699").ss(2,1,1).p("AqAAAIUCAA");
	this.shape_2.setTransform(55.7,17.2);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_2},{t:this.text},{t:this.instance},{t:this.shape_1},{t:this.shape}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-11.5,-4.4,135,23.6);


(lib.Symbol122 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.Puducherry();
	this.instance.setTransform(131.05,0,0.0801,0.0801);

	this.text = new cjs.Text("Puducherry", "bold 12px 'Arial'");
	this.text.lineHeight = 14;
	this.text.parent = this;
	this.text.setTransform(60.95,5.85);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(0.1,1,1).p("AgGAfQgBABgBACIgWAcIAAhIQAFgMADgMQACgHACgJQACgHADgCQADgCAFAAQAQABADABQAJACADAJQAFANAAAEQAAAIgJAOQgIALgUAdg");
	this.shape.setTransform(22.75,16.5208);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f().s("#CCFF00").ss(2,1,1).p("An9AAIP7AA");
	this.shape_1.setTransform(72.9875,19.6);

	this.shape_2 = new cjs.Shape();
	this.shape_2.graphics.f("#CCFF00").s().p("AgegKQAFgMADgMIAEgQQACgHADgCQADgCAFAAIAUACQAIACADAJQAFANABAEQgBAIgJAOIgcAoIgDADIgVAcg");
	this.shape_2.setTransform(22.75,16.5208);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_2},{t:this.shape_1},{t:this.shape},{t:this.text},{t:this.instance}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(18.6,0,137,23.7);


(lib.Symbol121 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.Chandigarh();
	this.instance.setTransform(0,0,0.0562,0.0562);

	this.text = new cjs.Text("Chandigarh", "bold 12px 'Arial'");
	this.text.textAlign = "center";
	this.text.lineHeight = 14;
	this.text.parent = this;
	this.text.setTransform(52.35,2.2);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#33332D").ss(0.1,1,1).p("AgIAEIgJgPIAQgJIABAAIAPAMIADAGIgDAVIgPACg");
	this.shape.setTransform(111.75,14.8);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f().s("#999999").ss(2,1,1).p("AG/AAIt9AA");
	this.shape_1.setTransform(66.125,15.1875);

	this.shape_2 = new cjs.Shape();
	this.shape_2.graphics.f("#999999").s().p("AgIAEIgJgOIAQgJIABAAIAPALIACAGIgCAVIgPABg");
	this.shape_2.setTransform(111.75,14.8);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_2},{t:this.shape_1},{t:this.shape},{t:this.text},{t:this.instance}]}).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,114.5,17.9);


(lib.Symbol120 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.Lakshadweep();
	this.instance.setTransform(-39.3,-31.15,0.0948,0.0948);

	this.text = new cjs.Text("Lakshadweep", "bold 12px 'Arial'");
	this.text.lineHeight = 14;
	this.text.parent = this;
	this.text.setTransform(-16.25,-28.25);

	this.shape = new cjs.Shape();
	this.shape.graphics.f("rgba(0,51,153,0.992)").s().p("ACiEFIgCAAQgEgEAAgIQADgHABgJIAAAAIAAgDIABAAIAAgBIAAgCQADgIAEgGQAIgDAKgBIABAAIAAAAIACAAIAAAAQABAAAAABQAAAAAAAAQABABAAAAQAAABAAAAIAAAAIAAAFIAAAAIgCALIgBAGQgEALgHAJIgBAAIgOAHIAAAAgAhqDjIAAAAIgBgGQAGgIAFgKIAAAAIAKgEIABAAIAAAAIADAAIAAAAQAEACAAAFIAAABIAAAEIAAABQgFAQgPAHIgCACIgGgKgAgZCgQgEgEgDgHIAAAAIAAgEQAAAAgBgBQAAAAAAgBQAAAAAAgBQAAAAAAgBQAHgJALgGQAGABAEACIABAAQAEAFABAHIAAADIAAAAIAAADQABACAAADIAAABQgLAGgQACgAgRBPIgBAAQgFAAgCgDIAAAAIgBgCIAAgBIAAgGIAFgLQAHABAEADIABAAQACAGABAIQgCADgEACIAAAAIgDABIgCgBgAhjBNIAAgEIgBAAIAAgOIABAAIAAgBIAAgBIADgFIAAgBQAEgBACgCIAAAAQAAAAABAAQAAAAAAAAQAAAAABAAQAAAAAAAAIALANIgCANIgTADIgBAAgAhIA5QgDgHgBgJQAEgJAJgEIABgBIAFAAIADAAIAAABIACAAIAAAAIAEARQgEAGgFAFIgEABIgDAAIgBAAIAAAAIgDAAIgEAAgAhxADIgBAAIAAgFIABAAIAAgCIAAgBIAAgCIAAAAIAAgCIAAAAIAAgDIAAAAIAAgBIABgJIAKgFIABAAIAPAJIABABQACAFAAAHIABADIgBAAIAAAAQgJADgIAFIgCABIgBAAIgCAAIgCAAIgDAAIAAAAIgBAAQgBAAAAAAQgBgBAAAAQAAgBAAAAQAAgBAAgBgAAVAHIgBAAIgDgBIgBAAIgHgBIAAAAQgFgGgCgKQANgIARgEIAEAAQAEAGgDAHIgEAKIgDACIgDADIgCABIAAABIgEAAgABHg3IgBAAIAAgEIABAAIAAgBQAAgFADgEIAHgBIABAAIAAgBIACABIAJAHIAAAAIABACIAAADQACACAAADQgEACgFABIgEABQgJAAgDgGgAhghTIgBgCIAHgZIAHgBIABgBIAOAJIABAAIgDAcIgagIgAiwhSIgBAAQgIgCgFgGIAAAAIAAgDQAEgLAIgJIAAAAIALAGIAAAAIAAANIAAAAQgBAIgGAEIAAAAIgBAAIgBAAgAAahbIgBAAQgIgBgFgEIAAAAIAAgDIAAgBIgBgDIAAAAIAAgCIAKgSIABAAIAAgBIAGABIACAAQAMAFgCARIAAACQgEAGgGACIAAABIgBAAIgDgBgAiSiGIgGgCQgDgBgBgDQACgFAAgHIAAAAIAKgJIABgBQAHAFAFAGIAAABIAAADIAAAEIAAABIABACIAAABIgBAAQgDAEgFACIgHgBgAhyjaIgCAAIgCgBQgGgFgFgHIgKgQIADgNIAIAAIASAOIABAEIgBAAIAAADIAAADIAAAEIAAAAIAAAEIAAADIAAAAIAAAFIgEACg");
	this.shape.setTransform(24.525,15.975);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("rgba(255,0,0,0.992)").s().p("AgDADIABgEIAAgBIAGAFg");
	this.shape_1.setTransform(11.275,-10.425);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape},{t:this.text},{t:this.instance}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-39.3,-31.1,103.89999999999999,73.2);


(lib.Symbol119 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.delhi();
	this.instance.setTransform(0,3.6,0.2203,0.2203);

	this.text = new cjs.Text("Delhi", "bold 12px 'Arial'");
	this.text.lineHeight = 14;
	this.text.lineWidth = 38;
	this.text.parent = this;
	this.text.setTransform(39.65,2);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("AANBLQgKgKgGACIgQgCQgJgGgFgFQgNABgJgIQgBgCAIgFQgRgGgCgOQgFgKABgNQgGgBAAgEQAAgJAKgJQAAgMAMgKQgEgHAHgHQgEgEADgDIAPAAQAEgKAMgEQAEgIAGgDIATgCQAKAEgBAGIASgDIAMAVQAEgBAPAFQACAEgDAMQAIAHgDAIQAJAMAAANIAAAlQgFAGgEAOQADALgDAMQgGAQgTAJQgIgKgOAAQgFgHgEgFg");
	this.shape.setTransform(205,9.7);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f().s("#666666").ss(2,1,1).p("Ai3HzIsqAAAPinyI53AA");
	this.shape_1.setTransform(106.825,67.075);

	this.shape_2 = new cjs.Shape();
	this.shape_2.graphics.f("#E6E6E6").s().p("AAWBXIgJgMQgKgKgGACIgQgBQgKgGgEgGQgNACgJgJQgBgBAIgGQgQgGgDgOQgGgKACgMQgGgBAAgFQgBgJALgJQAAgLAMgKQgEgIAHgHQgEgEADgDIAPAAQAEgKANgDQADgJAGgDIATgBQAJADAAAHIASgEIALAVQAFAAAPAEQACAEgDANQAIAGgDAJQAJALAAANIAAAlQgFAGgEAOQADALgDAMQgFAQgUAJQgIgKgOAAg");
	this.shape_2.setTransform(205,9.7);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_2},{t:this.shape_1},{t:this.shape},{t:this.text},{t:this.instance}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,-0.9,213.9,118.9);


(lib.Symbol118 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.text = new cjs.Text("Haryana", "bold 12px 'Arial'");
	this.text.lineHeight = 14;
	this.text.lineWidth = 56;
	this.text.parent = this;
	this.text.setTransform(24.5,11);

	this.instance = new lib.haryana();
	this.instance.setTransform(0,6.05,0.0213,0.0213);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("AD3jJIg1gTIgmg/IghgCIgOgKIAFAUIAXAdIASANIgRAOIgFAYIgnAFIAAAwIgdgLIgeAAIgLALIAKAbIgXAVIguACIgCgKIgnADIACAZIgTABIgIgMIgOAMIgbgBIgjg7IhFgDIAKBrIAAAGQBAgMAbApQATgGAJAKQA3A2gaAsIBGA/IAFAzIAQADQAxgyAWBIIAMABQgMg5ArAFIAHBjIAMABQAZgmAYAIQAwgDgHgXQgIgXAQgRQgVgCAAggIgaAFQgeAAgWgWQgWgVAAgeQAAgeAWgWQAMgMAOgFIACgMIAKgCIABgmIgKgBIABgkIASgOIAFg0IAYgQQAVgSAKgeg");
	this.shape.setTransform(171.5,29.625);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f().s("#FF9999").ss(2,1,1).p("AJkAAIzHAA");
	this.shape_1.setTransform(86.65,26.65);

	this.shape_2 = new cjs.Shape();
	this.shape_2.graphics.f("#FF9999").s().p("AB8EnIgHhjQgrgFAMA5IgMgBQgXhIgxAyIgQgDIgEgzIhHg/QAbgsg3g2QgJgKgSAGQgdgpg+AMIgBgGIgKhrIBFADIAjA7IAbABIAPgMIAHAMIATgBIgBgZIAmgDIACAKIAtgCIAYgVIgJgbIAKgLIAeAAIAeALIAAgwIAmgFIAEgYIASgOIgTgNIgVgdIgGgUIAOAKIAhACIAnA/IA0ATIgEALQgKAegVASIgYAQIgFA0IgSAOIgBAkIAKABIgBAmIgLACIgBAMQgPAFgLAMQgVAWAAAeQAAAeAVAVQAWAWAeAAIAagFQAAAgAVACQgQARAHAXQAIAXgwADQgZgIgZAmg");
	this.shape_2.setTransform(171.5,29.625);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_2},{t:this.shape_1},{t:this.shape},{t:this.instance},{t:this.text}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,-1,197.2,61.3);


(lib.Symbol115 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.DadraNagarHaveli();
	this.instance.setTransform(0,1.7,0.1663,0.1663);

	this.text = new cjs.Text("Dadra & Nagar Haveli", "bold 12px 'Arial'");
	this.text.textAlign = "center";
	this.text.lineHeight = 14;
	this.text.parent = this;
	this.text.setTransform(90.45,2);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(0.1,1,1).p("AA7ABIhZBXIgagCIABhHIgLgKIADgpIAMgJQAdgKAegKQA3gUAEgCg");
	this.shape.setTransform(161.75,11.3);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f().s("#0099CC").ss(2,1,1).p("AJ4AAIzvAA");
	this.shape_1.setTransform(92.25,18.95);

	this.shape_2 = new cjs.Shape();
	this.shape_2.graphics.f("#0099CC").s().p("Ag4BXIAChIIgMgKIADgoIAMgKIA7gUIA6gWIgHBYIhZBXg");
	this.shape_2.setTransform(161.75,11.3);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_2},{t:this.shape_1},{t:this.shape},{t:this.text},{t:this.instance}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,169.4,21.1);


(lib.Symbol110 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.Mizoram();
	this.instance.setTransform(121.7,8.2,0.082,0.082);

	this.text = new cjs.Text("Mizoram", "bold 12px 'Arial'");
	this.text.lineHeight = 14;
	this.text.lineWidth = 56;
	this.text.parent = this;
	this.text.setTransform(64.25,10.45);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("AAhi7IgCgKIgMgSIgEANIgPAGIgMgIIgIAAIgIAdIgWAXIgYgDIgZAnIAJAKIAABcIASgBIApCGIgJAWIgBAWIA8A1IAigBIAagkIAAgfIgTgEIgBhZIAagWIADgCIABgbIALgGIgChPIgJgFIAAgRIgKgCIgBgRIgJgDIgCgVIgBAAIgagdIAAgMg");
	this.shape.setTransform(10.025,21.6);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f().s("#FFFF00").ss(2,1,1).p("AHTAAIulAA");
	this.shape_1.setTransform(65.275,24.95);

	this.shape_2 = new cjs.Shape();
	this.shape_2.graphics.f("#FFFF00").s().p("AgpCjIABgWIAJgWIgpiFIgSABIAAhcIgJgLIAZgnIAYADIAWgXIAIgdIAIAAIAMAIIAPgFIAEgOIAMATIACAKIAHAAIAAALIAaAdIABAAIACAWIAJACIABASIAKABIAAASIAJAEIACBPIgLAGIgBAbIgDACIgaAXIABBZIATADIAAAfIgaAkIgiABg");
	this.shape_2.setTransform(10.025,21.6);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_2},{t:this.shape_1},{t:this.shape},{t:this.text},{t:this.instance}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-1,-1,148.3,45.2);


(lib.Symbol108 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.ArunachalPradesh();
	this.instance.setTransform(192.8,0.5,0.2418,0.2418);

	this.text = new cjs.Text("Arunachal Pradesh", "bold 12px 'Arial'");
	this.text.lineHeight = 14;
	this.text.lineWidth = 112;
	this.text.parent = this;
	this.text.setTransform(80.15,2);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("ACyCgIAOgLIAZgdIAcgBIADgZQgQAAgbgVIACgpIATglIg1gDQgMAIAHATQgXgGgFAGQgjAPgXAPIgtABQAAAdgSAMQgGgHgQAKQABgUgTAGQgHASgQAGIAAAVQgPgBgZAZIgQASQAIA6hegFIgKAMIhsgDIg+AgIgSgCIACgoIgNABIACgmIAKgNIgUgUIgoABIgcgfIgDgTIATgVIAWABIAKAKIASABIATgSIAWgNIApABIASgVIAAgUIAegcIAngCIADgeIAUgnIAdgTIADgBIAuAAIApggIAWg5IBSgpIAkAUIAqAAIAHAKIAVAAIA+hHIA8ABIAbAeIgmApIgCAIIAgABIATgVIAKAAIALAKIAAAUIgLAMIABAcIgLABIgLAVIABAQIAKAMIAAACIASgBIAigUIASABIAMAIIAdABIAHALIALAAIAVAUIAJAUIAAAIIAgAdIAIAPIgCAYIgSAAIgIANIgCBFIhFAAIAAgKIgTAAIgCgLIgKAAIgCAKIgGAAIgEAIIgaACIgOAUIgRAAIgDAKIgSAAIAAAKIgKAAIgBAKIgJAAIAAAJIgUABIAAANIgcgCIgJgUQgeAYgkAKQhPAzgZAa");
	this.shape.setTransform(47.5,35.85);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f().s("#FF8400").ss(2,1,1).p("AozAAIRnAA");
	this.shape_1.setTransform(132.4,19);

	this.shape_2 = new cjs.Shape();
	this.shape_2.graphics.f("#FF8400").s().p("Al/EIIABgnIgNABIADgnIAKgNIgVgTIgoAAIgcgeIgDgTIAUgVIAVAAIAKALIASABIATgTIAWgNIApACIASgWIAAgTIAfgdIAngCIACgdIAVgoIAcgTIADAAIAugBIApgfIAWg5IBRgqIAlAUIAqABIAHAKIAVAAIA+hIIA8ABIAbAeIgnApIgBAIIAgABIATgUIAJAAIALAJIABAVIgMAMIABAbIgKACIgLAUIABARIAKAMIAAABIASgBIAigUIASABIAMAJIAdAAIAHALIALABIAVAUIAJATIAAAJIAfAcIAJAPIgBAYIgTAAIgIANIgCBFIhFAAIgBgJIgSgBIgCgLIgKABIgCAJIgGABIgEAHIgaACIgNAUIgSAAIgDALIgRgBIgBALIgLgBIAAAKIgJABIgBAIIgTACIAAAMIgcgCIgJgTIAOgMIAYgdIAcgBIAEgZQgRAAgagVIACgpIATglIg1gDQgMAHAHAUQgXgGgFAGQgjAPgXAPIgtABQAAAegSAMQgGgHgQAJQABgTgTAFQgHASgRAGIABAWQgPgCgZAZIgQASQAIA6hegFIgKAMIhsgDIg9Agg");
	this.shape_2.setTransform(47.5,35.325);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_2},{t:this.shape_1},{t:this.shape},{t:this.text},{t:this.instance}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-1,0,230.1,64);


(lib.Symbol107 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.Nagaland();
	this.instance.setTransform(126.3,5.2,0.0597,0.0597);

	this.text = new cjs.Text("Nagaland", "bold 12px 'Arial'");
	this.text.lineHeight = 14;
	this.text.lineWidth = 62;
	this.text.parent = this;
	this.text.setTransform(64.3,5.7);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("ABNAjIABAQIgLABIABAUIgKABIAAAnIgLABIAAAKIgIAAIgBATIgTAEIgCgLIgHAAIgBgxIgeATIAAAdIgUABIgIgMIgyACIgMARIgHADIgEAUIgUAQIgGgBIgDgUIAAgaIgJgFIABghIARgVIASAAQgBAIAFADQAGgCAHACQAEgDAFAAIgCgRQAAgRAIgHQgBgaA5g4QgJgGARgSQAZgaBPgzQArgNAVgaIAVAhIgCASIgKAFIABAZIgLADIgBAcIgKACIABASIgLACIAAASIgJACIAAAdIgLAAIgBAKIgJAAIAAATIgLAAg");
	this.shape.setTransform(16.075,18.05);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f().s("#0000FF").ss(2,1,1).p("AnRAAIOjAA");
	this.shape_1.setTransform(70.3875,21.55);

	this.shape_2 = new cjs.Shape();
	this.shape_2.graphics.f("#0000FF").s().p("AiUC0IgDgUIAAgaIgJgFIABghIARgVIASAAQgBAIAFADQAGgCAHACQAEgDAFAAIgCgSQAAgQAIgHQgBgaA5g3QgJgHARgRQAZgaBPg0QArgNAVgaIAVAhIgCASIgKAFIABAZIgLADIgBAcIgKADIABARIgLADIAAARIgJACIAAAdIgLAAIgBAJIgJAAIAAAUIgLAAIAAADIABARIgLAAIABAUIgKAAIAAAoIgLABIAAAKIgIAAIgBAUIgTACIgCgKIgHAAIgBgwIgeASIAAAdIgUABIgIgLIgyABIgMASIgHACIgEATIgUAQg");
	this.shape_2.setTransform(16.075,18.05);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_2},{t:this.shape_1},{t:this.shape},{t:this.text},{t:this.instance}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-1,-1,143.5,38.1);


(lib.Symbol106 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.text = new cjs.Text("Assam", "bold 12px 'Arial'");
	this.text.lineHeight = 14;
	this.text.lineWidth = 47;
	this.text.parent = this;
	this.text.setTransform(143.95,2);

	this.instance = new lib.Assam();
	this.instance.setTransform(186.15,4.3,0.38,0.38);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#FFFFFF").ss(1,1,1,3,true).p("AACAAIgDAA");
	this.shape.setTransform(0.175,31.6);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f().s("#000000").ss(1,1,1,3,true).p("AG2jkQgiAfgqALQhPAzgZAaQgSASAKAGQg6A5ABAaQgIAGAAAQIACASIgsgIIgRAVIgBAhIAKAFIAAAxIgcACIABAxIgiAnIACAxIgPAaIgQAFIgLgIIgJAAIgHAdIgWAXIgYgCIgaAoIgWgTIADgGQAOgfAKgFIAEgBIACgrIgFgCQgYgMAFgxIAsAcIgCg+IAggoIglhIIg7AEIgPgVQAdgSgMggIgUAKIg0AAIhHA8IgiAAIgWgTIg7gBIgOgLIgPgBIgMALIg6AAIgYAMIgdg/IAJgCIAEgaIAIgFIABgUIAEgXIBZgqIAUALIBQABIAIgKIA5gBIASgJIBTAAQAfgQAfgQIBrADIAKgMQBfAFgJg6IAQgSQAZgZAPACIAAgWQAQgGAHgSQATgFgBATQARgJAGAHQASgMAAgeIAtgBQAXgPAjgPQAFgGAXAGQgHgUAMgIIA1ADIgTAmIgBApQAZAVARAAIgDAZIgdABIgZAdQgBACgCABg");
	this.shape_1.setTransform(52.7,40.675);

	this.shape_2 = new cjs.Shape();
	this.shape_2.graphics.f().s("#FFCE84").ss(2,1,1).p("AmwAAINhAA");
	this.shape_2.setTransform(139.7625,17.8);

	this.shape_3 = new cjs.Shape();
	this.shape_3.graphics.f("#FFCE84").s().p("AhMFzIADgGQAOgfAKgFIAEgBIACgrIgEgCQgZgMAGgxIArAcIgCg+IAggoIgkhIIg8AEIgPgVQAdgSgMggIgUAKIg0AAIhHA8IghAAIgXgTIg7gBIgOgLIgPgBIgMALIg5AAIgZAMIgdg/IAJgCIAEgaIAIgFIABgUIAFgXIBYgqIAUALIBRABIAHgKIA5gBIASgJIBTAAIA+ggIBrADIAKgMQBfAFgJg6IAQgSQAZgZAPACIAAgWQAQgGAHgSQATgFgBATQARgJAGAHQASgMAAgeIAtgBQAXgPAigPQAGgGAYAGQgIgUAMgIIA1ADIgTAmIgBApQAaAVAQAAIgDAZIgcABIgaAdIgDADQgiAfgqALQhPAzgZAaQgSASAKAGQg6A5ACAaQgIAGAAAQIABASIgsgIIgRAVIgBAhIAKAFIAAAxIgcACIABAxIgiAnIACAxIgOAaIgRAFIgLgIIgIAAIgIAdIgVAXIgYgCIgbAog");
	this.shape_3.setTransform(52.7,40.675);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_3},{t:this.shape_2},{t:this.shape_1},{t:this.shape},{t:this.instance},{t:this.text}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-1,0,222.1,80.7);


(lib.Symbol105 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.text = new cjs.Text("Meghalaya", "bold 12px 'Arial'");
	this.text.lineHeight = 14;
	this.text.lineWidth = 69;
	this.text.parent = this;
	this.text.setTransform(20.2,2);

	this.instance = new lib.Meghalaya();
	this.instance.setTransform(0,1.4,0.0303,0.0303);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("AjrgLIgHAKIAFA7IBFAeIAdgDIAAAJIBJABIABgKICGgBIAAgKIAfgBIAAgJIA9AAIADAKIAUABIAAAKIAbgCIAggnIglhHIg8AEIgOgVQAcgSgMggIgUAKIg0AAIhHA8IghAAIgWgTIg7gBIgOgLIgPgBIgMALIg6AAIgJAMIgJAEIgBAOg");
	this.shape.setTransform(50.1,99.1);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#00FF00").s().p("AiKBeIgBgJIgdACIhEgeIgGg6IAHgKIAIgEIABgOIAJgEIAJgMIA6AAIAMgLIAPABIAOALIA7ABIAWATIAhAAIBHg9IA0AAIAUgJQAMAggcASIAOAVIA8gEIAlBGIggAoIgbACIAAgKIgVgBIgCgKIg9AAIAAAJIgfABIAAAKIiGABIgBAKg");
	this.shape_1.setTransform(50.1,99.1);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape},{t:this.instance},{t:this.text}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,91.3,109.6);


(lib.Symbol92 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.text = new cjs.Text("Uttar Pradesh", "bold 10px 'Arial'");
	this.text.lineHeight = 11;
	this.text.parent = this;
	this.text.setTransform(24.05,49.45);

	this.instance = new lib.UttarPradesh();
	this.instance.setTransform(45.9,66.05,0.3166,0.3166);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("ADOh3IgVAAIgIgJIgoAAIgpgoIgHAAIgtggIABgKIgLgKIgLACIgkgfIgTAAIgsgFIgzgqIABgbIAUgPIAAhDIAZgUIAAglIg5AYIjGABIgGgWIgcgDIhwhBIgNg+IgZABIgEANQgKAdgVASIgYAQIgEA1IgTANIAAAlIAKAAIgBAoIgLACIgCANIAXgDQAeAAAVAVIALANQALARAAAWQAAAegWAVIgVAQQAAAeAUACQgPARAHAYQAHAXgwACIAcBRIAiAMIgXBaIBwgLIACgBQBogJAkBWIAIAYIgwBnIg5AwIgRAfIAAAlIgeAcIgBA9IAdAyIArAAIASAeIAWgWIgCgxIgdgOIgLhKIgJgBIAAgzIAegdIAdABIABAmIASAUIAOABIAKgLIAaAAIAVAUIA0ABIAmgoIAgABIARASIABApIAKgBIALgJIAkgBIAOgJIARACIADAbIAvAAIAUgSIAYAAIARgUIALAAIAKAIIAAAJIAUAAIATAVIAAALIAJAJIAJABIA2AnIAwAAIALAKIAAAVIAUAeIgBAIIgdAeIAAALIAJALIA7AAIANAJIAdgyIAKgIIAAg+IAJgIIAMgBIgBgVIgegdIgBgSIgJgMIAAgLIALgJIgBgVIAJgJIAKAAIALgKIAVAAIBFhFIAJgMIAfAAIAKALIATAAIAMgKIgBgLIgTgUIgrAAIgngoIABhDIALgBIAIgMIAeAAIAKgIIAAgMIgJgKIgLAAIgKgKIgLgBIgRgSIAAgNIgMgFIAAgWIgjgkIgtgDIgRATIgOAAIgIgJIgVAAIgIgLIggAAIgVgnIgxgBIgSgTIgKAAg");
	this.shape.setTransform(60.675,59.025);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#FFCE84").s().p("AFsJFIg7AAIgJgLIAAgLIAdgeIABgIIgUgeIAAgVIgLgKIgwAAIg2gnIgJgBIgJgJIAAgLIgTgVIgUAAIAAgJIgKgIIgLAAIgRAUIgYAAIgUASIgvAAIgDgbIgRgCIgOAJIgkABIgLAJIgKABIgBgpIgRgSIgggBIgmAoIg0gBIgVgUIgaAAIgKALIgOgBIgSgUIgBgmIgdgBIgeAdIAAAzIAJABIALBKIAdAOIACAxIgWAWIgSgeIgrAAIgdgyIABg9IAegcIAAglIARgfIA5gwIAwhnIgIgYQgkhWhoAJIgCABIhwALIAXhaIgigMIgchRQAwgCgHgXQgHgYAPgRQgUgCAAgeIAVgQQAWgVAAgeQAAgWgLgRIgLgNQgVgVgeAAIgXADIACgNIALgCIABgoIgKAAIAAglIATgNIAEg1IAYgQQAVgSAKgdIAEgNIAZgBIANA+IBwBBIAcADIAGAWIDGgBIA5gYIAAAlIgZAUIAABDIgUAPIgBAbIAzAqIAsAFIATAAIAkAfIALgCIALAKIgBAKIAtAgIAHAAIApAoIAoAAIAIAJIAVAAIALALIAKAAIASATIAxABIAVAnIAgAAIAIALIAVAAIAIAJIAOAAIARgTIAtADIAjAkIAAAWIAMAFIAAANIARASIALABIAKAKIALAAIAJAKIAAAMIgKAIIgeAAIgIAMIgLABIgBBDIAnAoIArAAIATAUIABALIgMAKIgTAAIgKgLIgfAAIgJAMIhFBFIgVAAIgLAKIgKAAIgJAJIABAVIgLAJIAAALIAJAMIABASIAeAdIABAVIgMABIgJAIIAAA+IgKAIIgdAyg");
	this.shape_1.setTransform(60.675,59.025);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape},{t:this.instance},{t:this.text}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-1,-1,123.4,120.1);


(lib.Symbol89 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.text = new cjs.Text("Himachal Pradesh", "bold 12px 'Arial'");
	this.text.textAlign = "center";
	this.text.lineHeight = 14;
	this.text.alpha = 0.87843137;
	this.text.parent = this;
	this.text.setTransform(106.75,21.8);

	this.instance = new lib.Himachalpngcopy();
	this.instance.setTransform(12.65,12.9,0.0905,0.0905);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("AC4hNIAdATIAAAUIALgBIAAAeIgJABIACAQIAZADIALALIABAtIgJACIgCAUIAKAEIABAaIg5ABIgCgLIgggKIgmABIgCALIgdgBIgaANIgXAcIAJASIADAVIgMAKIAAAMIAKAHIgDAfIgXABIAAACIg0gTIgng/IghgDIgKgIIgHgyQgWgIgQgUQg/gKAJgxIgvhYIgCgzIAdgjIAAg7IA0ABIApgrIAqAAIAuAsIAWgBIAQAUQAogDABAQQAKgYAeABQAYA+AegNQARAsAiAAg");
	this.shape.setTransform(25.4,25.275);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#99FF00").s().p("AgXDqIgmg/IgigDIgKgIIgIgyQgVgIgQgUQg/gKAJgxIgvhYIgCgzIAdgjIAAg7IAzABIApgrIAsAAIAtAsIAWgBIAQAUQAogDABAQQAKgYAeABQAXA+AfgNQAQAsAjAAIACAdIAdATIABAUIALgBIAAAeIgJABIACAQIAZADIALALIABAtIgJACIgCAUIAKAEIABAaIg5ABIgCgLIgggKIgmABIgCALIgdgBIgbANIgWAcIAJASIACAVIgLAKIAAAMIAKAHIgEAfIgWABIAAACg");
	this.shape_1.setTransform(25.4,25.275);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape},{t:this.instance},{t:this.text}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-1,-1,161.8,52.6);


(lib.Symbol84 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.text = new cjs.Text("Andaman and Nicobar", "bold 12px 'Arial'");
	this.text.lineHeight = 14;
	this.text.parent = this;
	this.text.setTransform(77.7,52.3);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#0033CC").ss(2,1,1).p("AqBAAIUEAA");
	this.shape.setTransform(140.2,68);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f().s("#000000").ss(1,1,1).p("AqOBYIgDAAIAAivIUjAAIAACvIgcAA");
	this.shape_1.setTransform(141.475,59.175);

	this.shape_2 = new cjs.Shape();
	this.shape_2.graphics.f().s("#0033CC").ss(2,1,1).p("AqBAAIUDAA");
	this.shape_2.setTransform(140.1875,68);

	this.shape_3 = new cjs.Shape();
	this.shape_3.graphics.f("#C3F7D5").s().p("AJ2BYI0EAAIgDAAIAAivIUjAAIAACvg");
	this.shape_3.setTransform(141.475,59.175);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape},{t:this.text}]}).to({state:[{t:this.shape_3},{t:this.shape_2},{t:this.shape_1},{t:this.text}]},4).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(74.7,49.4,133.60000000000002,19.6);


(lib.Symbol73Rajasthan = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.Symbol73Bihar = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.Symbol73TamilNadu = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_2
	this.shape = new cjs.Shape();
	this.shape.graphics.f("rgba(255,255,255,0.878)").s().p("AgIAKQgDgDAAgHQAAgFADgEQAEgEAEABQAFgBAEAEQADADAAAGIAAABIgSAAQAAAEACACQACADACAAQABAAAAAAQABAAABAAQAAgBABAAQAAAAABgBIACgDIAFAAQgBAEgDACQgDADgFAAQgEAAgEgEgAgEgHQgCACAAAEIANAAQAAgEgBgCQgCgCgEAAQgCAAgCACg");
	this.shape.setTransform(42.325,13.65);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("rgba(255,255,255,0.878)").s().p("AgGANIAAgZIAEAAIAAAEQAAAAABgBQAAgBAAAAQABgBAAAAQAAAAAAAAIADgBIAEABIgBAEIgEgBIgCABIgBADIgBAEIAAANg");
	this.shape_1.setTransform(40.325,13.625);

	this.shape_2 = new cjs.Shape();
	this.shape_2.graphics.f("rgba(255,255,255,0.878)").s().p("AgIAKQgDgDAAgHQAAgGAEgEQADgCAEAAQAFgBAEAEQADAEAAAFQAAAEgBADQgCADgDACIgGACQgEAAgEgEgAgEgHQgDADAAAEQAAAFADACQACADACAAQADAAADgDQACgCAAgFQAAgEgCgDQgDgCgDAAQgCAAgCACg");
	this.shape_2.setTransform(37.875,13.65);

	this.shape_3 = new cjs.Shape();
	this.shape_3.graphics.f("rgba(255,255,255,0.878)").s().p("AANANIAAgPIgBgEIgBgCIgCAAQgBAAgBAAQgBAAAAAAQgBAAAAABQgBAAAAAAQgCACAAAEIAAAOIgEAAIAAgQIgBgEQAAAAAAAAQAAgBgBAAQAAAAgBAAQAAAAgBAAIgDABQgBAAAAAAQgBAAAAABQAAAAAAAAQAAABgBAAIgBAFIAAANIgDAAIAAgZIADAAIAAAEIAEgDIAEgBIAFABIACADQACgEAGAAQADAAACACQADACAAAEIAAARg");
	this.shape_3.setTransform(34.4,13.625);

	this.shape_4 = new cjs.Shape();
	this.shape_4.graphics.f("rgba(255,255,255,0.878)").s().p("AAFANIgEgOIgBgFIgEATIgFAAIgIgZIAFAAIAEAOIACAFIABgFIAEgOIAEAAIADAOIACAFIABgFIAFgOIAEAAIgIAZg");
	this.shape_4.setTransform(29.125,13.65);

	this.shape_5 = new cjs.Shape();
	this.shape_5.graphics.f("rgba(255,255,255,0.878)").s().p("AgIAKQgDgDAAgHQAAgGAEgEQADgCAEAAQAFgBAEAEQADAEAAAFQAAAEgBADQgCADgDACIgGACQgEAAgEgEgAgEgHQgDADAAAEQAAAFADACQACADACAAQADAAADgDQACgCAAgFQAAgEgCgDQgDgCgDAAQgCAAgCACg");
	this.shape_5.setTransform(25.925,13.65);

	this.shape_6 = new cjs.Shape();
	this.shape_6.graphics.f("rgba(255,255,255,0.878)").s().p("AAGANIAAgPIgBgEIgCgCIgCAAIgFABQgCACABAFIAAANIgEAAIAAgZIAEAAIAAAEQACgEAFAAIAEABIADACIABADIABAEIAAAPg");
	this.shape_6.setTransform(23.15,13.625);

	this.shape_7 = new cjs.Shape();
	this.shape_7.graphics.f("rgba(255,255,255,0.878)").s().p("AAFASIgHgOIgEADIAAALIgEAAIAAgjIAEAAIAAAUIAKgKIAGAAIgKAJIALAQg");
	this.shape_7.setTransform(20.675,13.15);

	this.shape_8 = new cjs.Shape();
	this.shape_8.graphics.f("rgba(255,255,255,0.878)").s().p("AgIAKQgDgDAAgHQAAgGAEgEQADgCAEAAQAFgBAEAEQADAEAAAFQAAAEgBADQgCADgDACIgGACQgEAAgEgEgAgEgHQgDADAAAEQAAAFADACQACADACAAQADAAADgDQACgCAAgFQAAgEgCgDQgDgCgDAAQgCAAgCACg");
	this.shape_8.setTransform(16.425,13.65);

	this.shape_9 = new cjs.Shape();
	this.shape_9.graphics.f("rgba(255,255,255,0.878)").s().p("AAAARIgCgCIAAgFIAAgOIgDAAIAAgEIADAAIAAgGIADgDIAAAJIAFAAIAAAEIgFAAIAAAOIAAACIABABIACAAIACAAIAAAEIgDABIgDgBg");
	this.shape_9.setTransform(14.375,13.225);

	this.shape_10 = new cjs.Shape();
	this.shape_10.graphics.f("rgba(255,255,255,0.878)").s().p("AgIAKQgDgDAAgHQAAgFADgEQAEgEAEABQAFgBAEAEQADADAAAGIAAABIgSAAQAAAEACACQACADACAAQABAAAAAAQABAAABAAQAAgBABAAQAAAAABgBIACgDIAFAAQgBAEgDACQgDADgFAAQgEAAgEgEgAgEgHQgCACAAAEIANAAQAAgEgBgCQgCgCgEAAQgCAAgCACg");
	this.shape_10.setTransform(10.825,13.65);

	this.shape_11 = new cjs.Shape();
	this.shape_11.graphics.f("rgba(255,255,255,0.878)").s().p("AgGANIAAgZIAEAAIAAAEQAAAAABgBQAAgBAAAAQABgBAAAAQAAAAAAAAIADgBIAEABIgBAEIgEgBIgCABIgBADIgBAEIAAANg");
	this.shape_11.setTransform(8.825,13.625);

	this.shape_12 = new cjs.Shape();
	this.shape_12.graphics.f("rgba(255,255,255,0.878)").s().p("AgIAKQgDgDAAgHQAAgFADgEQAEgEAEABQAFgBAEAEQADADAAAGIAAABIgSAAQAAAEACACQACADACAAQABAAAAAAQABAAABAAQAAgBABAAQAAAAABgBIACgDIAFAAQgBAEgDACQgDADgFAAQgEAAgEgEgAgEgHQgCACAAAEIANAAQAAgEgBgCQgCgCgEAAQgCAAgCACg");
	this.shape_12.setTransform(6.375,13.65);

	this.shape_13 = new cjs.Shape();
	this.shape_13.graphics.f("rgba(255,255,255,0.878)").s().p("AAGASIAAgQQAAgBAAgBQAAAAAAAAQgBgBAAAAQAAgBgBAAQAAAAAAgBQgBAAAAAAQgBAAAAAAQgBgBAAAAIgDABIgCADIgBAEIAAAOIgFAAIAAgjIAFAAIAAANQADgEAEABIAEABIAEADIABAFIAAAQg");
	this.shape_13.setTransform(3.6,13.15);

	this.shape_14 = new cjs.Shape();
	this.shape_14.graphics.f("rgba(255,255,255,0.878)").s().p("AAFASIgHgOIgEADIAAALIgEAAIAAgjIAEAAIAAAUIAKgKIAGAAIgKAJIALAQg");
	this.shape_14.setTransform(-0.275,13.15);

	this.shape_15 = new cjs.Shape();
	this.shape_15.graphics.f("rgba(255,255,255,0.878)").s().p("AgHAKQgDgDAAgHQAAgDABgDQABgEADgBQADgBADAAQAEAAACACQADACABAEIgEABIgDgFQAAAAgBAAQAAAAAAgBQgBAAAAAAQgBAAAAAAQgDAAgCACQgCADAAAEQAAAFACACQACADACAAQABAAABAAQAAAAABAAQAAgBABAAQAAAAABgBQACgBAAgDIAEAAQAAAEgDADQgDADgFAAQgEAAgDgEg");
	this.shape_15.setTransform(-2.875,13.65);

	this.shape_16 = new cjs.Shape();
	this.shape_16.graphics.f("rgba(255,255,255,0.878)").s().p("AgBASIAAgZIADAAIAAAZgAgBgMIAAgFIADAAIAAAFg");
	this.shape_16.setTransform(-4.75,13.15);

	this.shape_17 = new cjs.Shape();
	this.shape_17.graphics.f("rgba(255,255,255,0.878)").s().p("AgBASIAAgjIADAAIAAAjg");
	this.shape_17.setTransform(-5.875,13.15);

	this.shape_18 = new cjs.Shape();
	this.shape_18.graphics.f("rgba(255,255,255,0.878)").s().p("AgHAKQgDgDAAgHQAAgDABgDQABgEADgBQADgBADAAQAEAAACACQADACABAEIgEABIgDgFQAAAAgBAAQAAAAAAgBQgBAAAAAAQgBAAAAAAQgDAAgCACQgCADAAAEQAAAFACACQACADACAAQABAAABAAQAAAAABAAQAAgBABAAQAAAAABgBQACgBAAgDIAEAAQAAAEgDADQgDADgFAAQgEAAgDgEg");
	this.shape_18.setTransform(-7.575,13.65);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_18},{t:this.shape_17},{t:this.shape_16},{t:this.shape_15},{t:this.shape_14},{t:this.shape_13},{t:this.shape_12},{t:this.shape_11},{t:this.shape_10},{t:this.shape_9},{t:this.shape_8},{t:this.shape_7},{t:this.shape_6},{t:this.shape_5},{t:this.shape_4},{t:this.shape_3},{t:this.shape_2},{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol73TamilNadu, new cjs.Rectangle(-56.5,8.5,148,9.600000000000001), null);


(lib.Symbol73MadhyaPradesh = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.Symbol73AndhraPradesh = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.Symbol72Telangana = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.instance = new lib.Telangana();
	this.instance.setTransform(-9.6,10.7,0.1462,0.1462);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol72Telangana, new cjs.Rectangle(-9.6,10.7,22,21.8), null);


(lib.Symbol72TamilNadu = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.instance = new lib.Telangana();
	this.instance.setTransform(0.95,-4.55,0.1462,0.1462);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol72TamilNadu, new cjs.Rectangle(1,-4.5,21.9,21.8), null);


(lib.Symbol72Rajasthan = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.instance = new lib.RajasthanRenewableEnergyCorporationLtd();
	this.instance.setTransform(-9.2,-14.9,0.0799,0.0799);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol72Rajasthan, new cjs.Rectangle(-9.2,-14.9,40.9,40.9), null);


(lib.Symbol72Orissa = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.instance = new lib.Odishapngcopy2();
	this.instance.setTransform(-8.9,-0.1,0.1409,0.1409);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol72Orissa, new cjs.Rectangle(-8.9,-0.1,24.8,33), null);


(lib.Symbol72Maharashatra = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.instance = new lib.Maharashtra();
	this.instance.setTransform(4.8,-13.55,0.1457,0.1457);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol72Maharashatra, new cjs.Rectangle(4.8,-13.5,24.9,35.4), null);


(lib.Symbol72Karnataka = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.instance = new lib.Karnataka();
	this.instance.setTransform(2.05,-5.7,0.0721,0.0756);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol72Karnataka, new cjs.Rectangle(2.1,-5.7,25.299999999999997,30.3), null);


(lib.Symbol72Gujarat = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.instance = new lib.Gujarat();
	this.instance.setTransform(-15.8,-5.35,0.1727,0.1727);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol72Gujarat, new cjs.Rectangle(-15.8,-5.3,55.3,25.900000000000002), null);


(lib.Symbol72AndhraPradesh = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.instance = new lib.AndhraPradesh();
	this.instance.setTransform(-8.75,9.45,0.1055,0.1055);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol72AndhraPradesh, new cjs.Rectangle(-8.7,9.5,26.5,25.799999999999997), null);


(lib.Symbol72MadhyaPradesh = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.instance = new lib.MadhyaPradeshUrjaVikasNigamLimitedlogo();
	this.instance.setTransform(1.4,-0.6,0.135,0.135);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol72MadhyaPradesh, new cjs.Rectangle(1.4,-0.6,30.400000000000002,30.400000000000002), null);


(lib.Symbol72Bihar = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.instance = new lib.Bihar();
	this.instance.setTransform(1,5.75,0.0589,0.0589);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol72Bihar, new cjs.Rectangle(1,5.8,10.6,12.8), null);


(lib.Symbol72 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.instance = new lib.punjab();
	this.instance.setTransform(0,0,0.1131,0.1131);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol72, new cjs.Rectangle(0,0,22.7,22), null);


(lib.Symbol71Telangana = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,0,0,3,true).p("ACjh1IgpgeIgBABQgbAaggg7QgIhMAUgkIgbgWQgbAyglgdQgsAfgkg6QgPgxhUAcQgUB3g2ggIgMAMQglAoAlAXIAOAHIgOAYIgdAoIgfAeIAOBYQAAAOghgEIAPAZIARAVQgwAXAIBMQA1Aog+AzQApAXAAAbIgEAaQANAAALAFIATAKIAbADQAGABAFgFQAFgGAGgDIAIgHQAHgLANgGQAKgFANAAIBVgDQAIgGAAgGQgBgHAKAAQATABANgNIALgIQAEgCgBgGQgBgKAFgIIAFgKQADgNAMAAIAqgBQANABAHgGIAHgDQAPgFAPgDIAPgGIANgCQASgBAMgLQANgGAAgLQAEgLAFgBIAIgDQAHgFADgCIBGgCIAjgiQAJgJAIgGIAIgFQAKgHAPgBIATgFIANgHQAEgCAAgFIABgZQgBgJALgEIgmgBIgGABIhDAAIgKgMIAAgmIg0gnIAMgLIgMgLIACgKIgVgRg");
	this.shape.setTransform(26.1924,42.8615);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#FF6F6F").s().p("AkMFfIgbgDIgTgKQgLgFgNAAIAEgaQAAgbgpgXQA+gzg1goQgIhMAwgXIgRgVIgPgZQAhAEAAgOIgOhYIAfgeIAdgoIAOgYIgOgHQglgXAlgoIAMgMQA2AgAUh3QBUgcAPAxQAkA6AsgfQAlAdAbgyIAbAWQgUAkAIBMQAgA7AbgaIABgBIApAeIASAAIAVARIgCAKIAMALIgMALIA0AnIAAAmIAKAMIBDAAIAGgBIAmABQgLAEABAJIgBAZQAAAFgEACIgNAHIgTAFQgPABgKAHIgIAFQgIAGgJAJIgjAiIhGACIgKAHIgIADQgFABgEALQAAALgNAGQgMALgSABIgNACIgPAGQgPADgPAFIgHADQgHAGgNgBIgqABQgMAAgDANIgFAKQgFAIABAKQABAGgEACIgLAIQgNANgTgBQgKAAABAHQAAAGgIAGIhVADQgNAAgKAFQgNAGgHALIgIAHQgGADgFAGQgEAEgEAAIgDAAg");
	this.shape_1.setTransform(25.875,42.8615);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol71Telangana, new cjs.Rectangle(-12.7,6.8,77.2,72.2), null);


(lib.Symbol71Orissa = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("AH6koIgngmIgVgNIgJANIg7gxIgfAAIAAAAIgJgLIgUgCIgLgTIgSgBIgKgTIgNAAIgJALIAAATIAKAMIAAASIgdAzIgUggIhvABIgKgHIAAgOIAIgHIAMgBIgBgMIgTgRIgXAAIgFAIIhHAAIgIAMIgNAAIAAgLIg8AAIgmAmIgMACIgJAMIAAAvIgoBIIgMAJIAAAfIgRASIhPAAIgMALIgBALIgcAdIgNAAIgSAVIAKAJIAAAKIAJAKIABAIIAKAOIAAA5IAdAdIAWABIAJAMIgBAPIgIAOIgLAAIgTgUIgqgBIgqgoIgHAAIgVAVIABAHIAdAgIAfCdIgzArIAAASIhEBHIgBAcIgXAsIAGgBIAmABQAqg5BDACIAThEIAVADQgCAmAYgHQBHgYgOg5IAtgLIAPgyIArAAQAXAiAkAGQAyAHBCguQAfgnA/gvQgLgVADgWQAQgRARgIQALgFALgCIAAAqIAogGQAngmA4ABIAvghIAAgWIAzgZIgBgaIgKgCIgBgTIAfgOIgBgtIgJgEIAAgjIgKgFIAAgiIAGgJQASgUAvgTIAQgHg");
	this.shape.setTransform(15.05,48.075);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#CC66FF").s().p("AnzGzIgGABIAXgsIABgcIBFhHIAAgSIAygrIgfidIgdggIgBgHIAVgVIAIAAIApAoIAqABIATAUIALAAIAIgOIABgPIgJgMIgWgBIgcgdIAAg5IgLgOIAAgIIgKgKIAAgKIgKgJIASgVIANAAIAcgdIABgLIAMgLIBPAAIARgSIAAgfIAMgJIAohIIABgvIAIgMIAMgCIAmgmIA8AAIAAALIANAAIAIgMIBHAAIAFgIIAYAAIATARIABAMIgNABIgHAHIAAAOIAKAHIBugBIAUAgIAcgzIAAgSIgKgMIAAgTIAKgLIANAAIAKATIATABIAKATIAUACIAJALIAAAAIAfAAIA7AxIAJgNIAVANIAnAmIAAAVIgRAHQgvATgRAUIgHAJIAAAiIAKAFIAAAjIAJAEIABAtIgfAOIABATIAKACIABAaIgzAZIAAAWIgvAhQg4gBgnAmIgoAGIAAgqQgLACgLAFQgRAIgQARQgDAWALAVQg+AvggAnQhCAugygHQgkgGgXgiIgrAAIgPAyIgsALQANA5hHAYQgYAHACgmIgVgDIgSBEQhEgCgqA5g");
	this.shape_1.setTransform(15.05,48.075);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol71Orissa, new cjs.Rectangle(-36.5,3.5,103.2,89.2), null);


(lib.Symbol71Maharashatra = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("Ak+n2Ig0gpIAAgWIgJgJIgVABIgIAKIhWgCQgBAOADALQABALAEAIIAHAJQAJAKARgBIAAAlIgoAQIAAAYIATArIgbA9Ig4gXIgFAqIh/AvIgKA1IAMAJIAACSIAdATIgVAZIACBkIAjByIAtERIAvBJIAngBIAVAUIAqgnIApgBIgKg6IAIgdIgggGIACgwIApgLIAcAZIAAghIAmAAIATgiIAkANIAkgfIAVAMIAaglQgYgXASgSIACgCIB6AVIAAhCIA5gEIAhhHQArgCARglIAqAJQAvgeAmhHQhAgZA+g4QA2AgAUh3QBUgcAPAxQAkA6AsgfQAmAdAbgyIAbAWQgUAkAIBMQAgA6AbgaIAVgXIAAgwIAJgIIAAgOIAegdIAJAJIAdAAIANgIIAAgVIg9g7IAAgLIALgJIAAgVIgVgNIABgRIAegeIAAgWIgMgJIABgcIAKgLIgTgUIAAgzIAegSIg9gyIglAAIgBAKIgWAAIgJgLIg5AAIgjgUIgdAAIgxApIgfAAIgKgLIgWAAIgSgUIgVAAIgoAeIgnAAIgKAKIgoAAIgLgLIABgKIAJgHIAAgYIgRgRIgNAAIgIAHIgzABIg6A8IAAALIgnAeIgpAAIgigyIhzABIg9gog");
	this.shape.setTransform(49.8,36.325);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#FFCCCC").s().p("An/IrIgnABIgwhJIgtkRIgkhyIgBhkIAVgZIgegTIAAiSIgLgJIAKg1IB/gvIAFgqIA4AXIAbg9IgTgrIAAgYIAogQIAAglQgQABgKgKIgGgJQgFgIgCgLQgCgLABgOIBWACIAIgKIAVgBIAJAJIAAAWIAzApIAVAAIA9AoIBzgBIAiAyIApAAIAngeIAAgLIA5g8IA0gBIAIgHIAMAAIASARIAAAYIgKAHIgBAKIALALIAqAAIAJgKIAmAAIApgeIAVAAIASAUIAVAAIALALIAeAAIAxgpIAeAAIAjAUIA5AAIAJALIAVAAIABgKIAmAAIA9AyIgfASIABAzIATAUIgKALIgBAcIALAJIABAWIgeAeIgBARIAUANIABAVIgLAJIAAALIA9A7IAAAVIgOAIIgcAAIgJgJIgeAdIAAAOIgJAIIAAAwIgVAXQgbAaggg6QgJhMAVgkIgbgWQgbAygmgdQgsAfgkg6QgQgxhUAcQgTB3g2ggQg+A4BAAZQgmBHgvAeIgqgJQgRAlgrACIgiBHIg4AEIAABCIh6gVIgCACQgSASAYAXIgaAlIgVgMIgkAfIgkgNIgTAiIglAAIgBAhIgcgZIgpALIgBAwIAfAGIgJAdIAKA6IgoABIgqAng");
	this.shape_1.setTransform(49.8,36.325);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol71Maharashatra, new cjs.Rectangle(-21.2,-22.1,142.1,116.9), null);


(lib.Symbol71Karnataka = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("Ak9lHIAcAZIAAghIAmAAIATgiIAjANIAkgfIAWAMIAaglQgZgXATgSIACgCIB5AVIAAhCIA4gEIAjhHQAqgCARglIArAJIAKgHIAOBZQABAOghgEIAOAZIARAVQgvAXAHBMQA2Aog+AzQAoAXAAAbIgHA1IhLAFIgEBAIAUAvIAAAiIg/ACIgCBlIAgAhIAvgMIAdARIgDAyIgXALIhEgXIAYA4IAugIIAzAXIA9gvQAvBFAkALIACAxIAjAOIgWAXQAPATg6AZIACAeQgwhFhVBLIgBAxIAiAhQALAphIAnQhfgPAMApIgsACIhBghQgdgMgRgjQgvAqhNiMQgjgEgngxIghgCIgBgWQgKjXg+g8QgFg8gWgmIAmghIgNh9IAEgDIAogBIgKg6IAJgdIgggGIACgwg");
	this.shape.setTransform(41.675,23.575);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#FFCC00").s().p("AgTJGQgdgMgRgjQgvAqhNiMQgjgEgngxIghgCIgBgWQgKjXg+g8QgFg8gWgmIAmghIgNh9IAEgDIAogBIgKg6IAJgdIgggGIACgwIApgLIAcAZIAAghIAmAAIATgiIAjANIAkgfIAWAMIAaglQgZgXATgSIACgCIB5AVIAAhCIA4gEIAjhHQAqgCARglIArAJIAKgHIAOBZQABAOghgEIAOAZIARAVQgvAXAHBMQA2Aog+AzQAoAXAAAbIgHA1IhLAFIgEBAIAUAvIAAAiIg/ACIgCBlIAgAhIAvgMIAdARIgDAyIgXALIhEgXIAYA4IAugIIAzAXIA9gvQAvBFAkALIACAxIAjAOIgWAXQAPATg6AZIACAeQgwhFhVBLIgBAxIAiAhQALAphIAnQhfgPAMApIgsACg");
	this.shape_1.setTransform(41.675,23.575);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol71Karnataka, new cjs.Rectangle(1,-38.9,81.4,125), null);


(lib.Symbol71AndhraPradesh = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,0,0,3,true).p("ACVkyQAEgCAAgFIABgZQgBgJALgDQAqg6BDACIAThEIAVADQgCAmAYgGQBHgZgOg4IAtgMIAPgxIArAAQAXAiAkAGQAzAHBEgwIggBAQglAsgmA3IgrAJQg5AbgVA7Ig+A9QgegHhJBDIADAbQAPAAAFAKQAGAMgKAaQhXBDhlgfQgOAPgEAjQgEA9g4AMQgOgxgfASQgxAkgbA1IALEeIAXADIgEAoIgbAAIgyA7IhFgMQgQA0gZgTIgKAgIhTgNIgkBCQgjAQgOgTIgCgEIgBgYQA5gagPgSIAWgXIgigPIgCgwQglgLgvhGIg9AwIgzgXIguAIIgXg4IBDAWIAYgKIACgyIgdgRIgvAMIggghIADhnIA/gCIAAgiIgVgvIAFg+IBLgFIADgbQANAAALAEIATAKIAbADQAGACAFgFQAFgGAGgEIAIgGQAHgMANgGQAKgFANAAIBVgCQAIgGAAgHQgBgHAKABQATAAANgMIALgIQAEgCgBgHQgBgKAFgIIAFgJQADgOAMAAIArAAQANAAAHgFIAHgEQAPgFAPgCIAPgHIANgCQASgBAMgKQANgHAAgLQAEgLAFgBIAIgDQAHgFADgBIBFgCIAjgiQAJgJAIgGIAIgFQAKgHAPgCIATgEg");
	this.shape.setTransform(51.6422,27.023);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#FF9999").s().p("AmkJAIgCgDIgBgZQA5gZgPgTIAWgXIgjgOIgCgxQgkgLgvhFIg9AvIgzgXIguAIIgXg4IBDAXIAYgLIACgyIgdgRIgvAMIggghIAChmIA/gCIAAgiIgUgvIAEg/IBMgFIADgbQAMAAAMAFIATAKIAbADQAGABAEgFQAFgGAGgDIAJgHQAHgLANgGQAKgFANAAIBUgDQAJgGgBgGQAAgHAKAAQATABANgNIALgIQADgCAAgGQgBgKAFgIIAEgKQAEgNAMAAIArgBQAMABAIgGIAHgDQAPgFAOgDIAQgGIAMgCQATgBAMgLQANgGAAgLQAEgLAEgBIAIgDIALgHIBFgCIAjgiQAIgJAJgGIAIgFQAJgHAPgBIAUgFIANgHQAEgCAAgFIAAgZQAAgJALgEQAqg5BDACIAThEIAVADQgDAmAZgHQBGgYgNg5IAtgLIAPgyIAqAAQAXAiAlAGQAzAHBEgwIggBAQglAtgmA2IgsAKQg4AbgVA7Ig+A9QgegHhKBDIAEAaQAPABAFAJQAFAMgJAbQhXBDhlgfQgOAPgEAjQgEA8g5ANQgNgxgfASQgxAkgcA1IAMEdIAXADIgEAoIgbAAIgzA8IhEgMQgRA0gZgTIgJAgIhTgNIgkBCQgQAHgMAAQgOAAgHgLg");
	this.shape_1.setTransform(51.35,27.3856);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol71AndhraPradesh, new cjs.Rectangle(-17.2,-32.3,137.2,119.39999999999999), null);


(lib.Symbol71TamilNadu = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("AjNBHIACAoIgNAKIgCAzIAXAnIAAA0QgWAHgLAsIgFB4Ig3gBIBiBMIAVAHIAXgEIALgcQA1gOAPgRQAVgeAAglQAag2AZgcQBFgDAlgVIABgaIgMgBIgBAAIAAgBIgEgdQBEhAADgsQAOgNAGgTIBNAAQASiDgIiQQgHgDgCgOIBIhhQAKhNAZgvIABgxQgXgbgogJIgiAxIhFgMQgQA0gZgTIgKAgIhTgNIgkBCQgjAQgNgTIgEgDQgzhBguBAQgTAAgPALIAAAyIAhAgQALAphIAnQhegOALApIgsACIgxgZQgwAtBBAQIAAAoIApAOIgDAoIAWAaIgBAcQgkA1A5AMIAxgNIAAgK");
	this.shape.setTransform(26.51,30.075);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#C2CEE3").s().p("Ai+H9IhihMIA3ABIAFh4QALgsAWgHIAAg0IgXgnIACgzIANgKIgCgoIAAgKIAAAKIgxANQg5gMAkg1IABgcIgWgaIADgoIgpgOIAAgoQhBgQAwgtIAxAZIAsgCQgLgpBeAOQBIgngLgpIghggIAAgyQAPgLATAAQAuhAAzBBIAEADQANATAjgQIAkhCIBTANIAKggQAZATAQg0IBFAMIAigxQAoAJAXAbIgBAxQgZAvgKBNIhIBhQACAOAHADQAICQgSCDIhNAAQgGATgOANQgDAshEBAIAEAdIAAABIABAAIAMABIgBAaQglAVhFADQgZAcgaA2QAAAlgVAeQgPARg1AOIgLAcIgXAEg");
	this.shape_1.setTransform(26.51,30.075);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol71TamilNadu, new cjs.Rectangle(-11.7,-22.5,76.5,105.2), null);


(lib.Symbol71Rajasthan = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("AhynPQAOgzAmgfIANg9QAXgXAWgJQARgHATACIAIANQAWAYBBgIIALB5QA/gMAcAqQATgHAIALQA4A2gbAsIBGA/IAFAzQBHgqASBDIAPgDQgVg1AxAFIAHBlIA9gfIAbBRIAjALIgYBbIBrgLQgoA7iIArQgfA1hMAhQgTB8CSg6QAXAigHAaQgMgGhCATIgMA0QAuABgHAvQgpgZgEANQAZCJg/haQgjAXgigaQgHACgHgFQgDAuhHAxQgjgRABgeQA5gLAHhIQAnAFgmg9IhhALIAagwIgbgRIgaATIgYApIggAVQAOBKAXAdQgeAlATAsIgFAIIgpAdIAGAmQgeAYgZABIg9hDIgaADIgZgqIgmgVQAEg6gygkQAJg4gTgLIgPAjQguAXhehaQg9AMgsgEQgngFgZgSQgCgWgLgMQgHgtgigUIgNhZQgjAigjgyIAOh3IgZgQIgpgIIgpgoIAJgzIAAgeQBDggBLhiIA7AMIAFAyIAlAEQAmgnBOABQA6gSgFgwQAsglAsg+g");
	this.shape.setTransform(22.775,34.5438);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#CCCCFF").s().p("AgFJCIgaADIgZgqIgmgVQAEg6gygkQAJg4gTgLIgPAjQguAXhehaQg9AMgsgEQgngFgZgSQgCgWgLgMQgHgtgigUIgNhZQgjAigjgyIAOh3IgZgQIgpgIIgpgoIAJgzIAAgeQBDggBLhiIA7AMIAFAyIAlAEQAmgnBOABQA6gSgFgwQAsglAsg+IBRgmQAOgzAmgfIANg9QAXgXAWgJQARgHATACIAIANQAWAYBBgIIALB5QA/gMAcAqQATgHAIALQA4A2gbAsIBGA/IAFAzQBHgqASBDIAPgDQgVg1AxAFIAHBlIA9gfIAbBRIAjALIgYBbIBrgLQgoA7iIArQgfA1hMAhQgTB8CSg6QAXAigHAaQgMgGhCATIgMA0QAuABgHAvQgpgZgEANQAZCJg/haQgjAXgigaQgHACgHgFQgDAuhHAxQgjgRABgeQA5gLAHhIQAnAFgmg9IhhALIAagwIgbgRIgaATIgYApIggAVQAOBKAXAdQgeAlATAsIgFAIIgpAdIAGAmQgeAYgZABg");
	this.shape_1.setTransform(22.775,34.5438);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol71Rajasthan, new cjs.Rectangle(-48.7,-30.9,143,130.9), null);


(lib.Symbol71Gujarat = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("AA6D6QA3gNAUg2QALg1gTgrIAAgBQABgVAHgOQAKgXAXgCIAMBgIAdAIIAAAlIgYAWIAIBCIAbA1IgbBuICAgvIAFgrIA4AXIAbg9IgTgrIAAgYIAogQIAAglQgQABgKgJIgGgJQgFgIgBgMQgCgKAAgOIBBABIAEhJIANgJIgKgcIA3gZIgSg7Ig6g/IgaADIgZgpIgmgWQAEg5gyglQAJg3gTgMIgPAjQgZAKgVgKQgegIhAg7Qg9ANgsgFQgngEgZgVQgIA6gsALIgQgiIhYAMIgcAnIglABIgUghIhBABIgzgTIgmAXIAIAvIhgADQgIBPA4gqIAZAAIAJAMIgJALQgNALgXAGQANAcAXAcQAkAsA9ApQCHACAzgXQgBA2hnAcIhbAfQgdgCgMgmQgLgKgRAeQATAhAcAkIAcAjQAhAmArApQBFBbBAArIDDgu");
	this.shape.setTransform(18.75,42.825);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#BDBDBD").s().p("ADaE0Igbg1IgIhCIAYgWIAAglIgdgIIgMhgQgXACgKAXQgHAOgBAVIAAABQATArgLA1QgUA2g3ANIAAADIjCAuQhBgrhFhbQgqgpgigmIgcgjQgcgkgTghQARgeALAKQANAmAcACIBcgfQBmgcABg2QgzAXiHgCQg8gpglgsQgWgcgOgcQAXgGANgLIAKgLIgKgMIgZAAQg4AqAIhPIBggDIgIgvIAmgXIAzATIBBgBIAVAhIAkgBIAcgnIBZgMIAPAiQAsgLAIg6QAaAVAmAEQArAFA+gNQBAA7AeAIQAVAKAZgKIAPgjQATAMgJA3QAyAlgEA5IAmAWIAZApIAagDIA6A/IASA7Ig3AZIAJAcIgMAJIgEBJIhBgBQgBAOACAKQACAMAFAIIAGAJQAKAJAQgBIAAAlIgoAQIAAAYIATArIgbA9Ig4gXIgFArIiAAvg");
	this.shape_1.setTransform(18.75,42.825);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol71Gujarat, new cjs.Rectangle(-33.7,0.1,105,85.5), null);


(lib.Symbol71Bihar = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("AGMhiIgzAwIABATIAJAKIABATIASAZIABAOIgMAUIgZABIgCAAQg6gHhGAgQgTA4ALAsQghgIgbAMQgZAPgKAXQgZgdgvgXQgmANgNAbIhHAfIhDgDQABAVgWAOIgegTIgbAaIgbgVIhyACIAAgQIAKgIIALAAIAAgWIgfgcIAAgSIgKgMIAAgMIAMgIIgCgWIAKgJIAKAAIALgJIAVAAIBEhFIAJgNIAfAAIALALIATAAIALgKIAAgKIgTgUIgrABIgngpIAAhDIAMgBIAHgMIAfAAIAJgIIABgMIgKgKIgLAAIgKgKIgKgBIgSgSIAAgNIgLgFIAAgXIgSgWIAIgdIAzABIBDAqIADAeIAKAIIASABIA+AnIAeABIAJgKIAeABIATATIABALIALAJIAJAAQAPgKAOgKIASAAIABAJIAdABIAkAUIBDAAIAKgLIAdAdIApAAIAKgIIAxAAIALgKIAcAAIAKgIIAMAJg");
	this.shape.setTransform(22.25,30.7);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#8BCEDA").s().p("AkFEGIhyACIAAgQIAKgIIALgBIAAgUIgegdIgBgSIgJgNIAAgLIALgJIgBgVIAJgJIAKAAIALgJIAVAAIBEhFIAJgMIAgAAIAKALIATAAIALgLIAAgKIgTgUIgrAAIgngoIAAhDIAMgBIAHgMIAfAAIAKgIIAAgLIgJgLIgMABIgKgKIgKgCIgSgSIAAgNIgLgFIAAgWIgSgXIAIgdIAzABIBEAqIACAeIAKAIIASABIA+AnIAfABIAJgKIAdABIATATIABALIALAJIAJAAIAegUIARAAIABAKIAdAAIAkAUIBCgBIALgKIAdAdIApAAIAJgIIAyAAIALgKIAbAAIALgIIAMAJIABAVIgzAwIAAATIAJAKIABATIATAZIAAAOIgLAUIgaABIgBAAQg7gHhFAgQgUA4AMAsQgigJgaANQgZAPgKAXQgZgegwgWQgmANgLAbIhIAfIhDgDQACAVgXANIgegTIgaAbg");
	this.shape_1.setTransform(22.25,30.7);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol71Bihar, new cjs.Rectangle(-18.3,1.4,81.1,58.6), null);


(lib.Symbol71MadhyaPradesh = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("ALmAUIg7AAIgJgLIAAgKIAdgeIABgIIgUgeIAAgVIgLgKIgwAAIg2gnIgJgBIgJgJIAAgLIgTgVIgUAAIAAgJIgKgIIgLAAIgRAUIgYAAIgUASIgvAAIgDgbIgSgCIgOAJIgkABIgLAJIgKABIgBgpIgRgSIgggBIgmAoIg0gBIgVgUIgaAAIgKALIgOgBIgSgUIgBgmIgdgBIgeAdIAAAzIAJABIALBKIAdAOIACAxIgWAWIgSgeIgqAAIgdgyIABg9IAegcIAAglIARgfIA4gwIAwhnIgIgYQgkhWhpAKQgvA8iGAqQggA1hLAiQgTB8CRg6QAXAhgGAbQgNgGhCATIgLAzQAuABgHAvQgqgZgDAOQAYCIg/haQgiAXgjgZQgHACgHgGQgCAvhHAvQgjgRABgdQA4gLAHhIQAnAGglg9IhiAKIAbgwIgcgQIgZATIgZAoIggAWQAPBJAXAdQgfAkATAsIgFAIIgoAeIAGAlQgeAYgZABIgCAGIANAsIAEAFIgWAIIghASIAIAcIgMAJIgDBKIAUgBIAIgJIAVgBIAJAJIAAAWIAzAoIAUAAIA+AoIBzAAIAhAyIAqAAIAmgfIABgKIA6g8IA0gBIAIgHIAMAAIASAQIAAAYIgKAIIgBAKIALAKIApAAIAKgJIAmAAIAogeIAWAAIASATIAUAAIALALIAeAAIAxgoIAdgBIAjAVIA6gBIAIALIAWAAIABgKIAmAAIAiAcIBBhkIAbARICDiTIANgcQgagXgjgmQBCgCAhADIAcgqQAtgVAtgJIAtgw");
	this.shape.setTransform(32.825,18.2982);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#FFFF99").s().p("AmfH+IghgyIhzAAIg+goIgUAAIgzgoIAAgWIgJgJIgVABIgIAJIgUABIADhKIAMgJIgIgcIAhgSIAWgIIgEgFIgNgsIACgGQAZgBAegYIgGglIAogeIAFgIQgTgsAfgkQgXgdgPhJIAggWIAZgoIAZgTIAcAQIgbAwIBigKQAlA9gngGQgHBIg4ALQgBAdAjARQBHgvACgvQAHAGAHgCQAjAZAigXQA/BagYiIQADgOAqAZQAHgvgugBIALgzQBCgTANAGQAGgbgXghQiRA6ATh8QBLgiAgg1QCGgqAvg8QBpgKAkBWIAIAYIgwBnIg4AwIgRAfIAAAlIgeAcIgBA9IAdAyIAqAAIASAeIAWgWIgCgxIgdgOIgLhKIgJgBIAAgzIAegdIAdABIABAmIASAUIAOABIAKgLIAaAAIAVAUIA0ABIAmgoIAgABIARASIABApIAKgBIALgJIAkgBIAOgJIASACIADAbIAvAAIAUgSIAYAAIARgUIALAAIAKAIIAAAJIAUAAIATAVIAAALIAJAJIAJABIA2AnIAwAAIALAKIAAAVIAUAeIgBAIIgdAeIAAAKIAJALIA7AAIANAKIgtAwQgtAJgtAVIgcAqQghgDhCACQAjAmAaAXIgNAcIiDCTIgbgRIhBBkIgigcIgmAAIgBAKIgWAAIgIgLIg6ABIgjgVIgdABIgxAoIgeAAIgLgLIgUAAIgSgTIgWAAIgoAeIgmAAIgKAJIgpAAIgLgKIABgKIAKgIIAAgYIgSgQIgMAAIgIAHIg0ABIg6A8IgBAKIgmAfg");
	this.shape_1.setTransform(32.825,18.2982);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol71MadhyaPradesh, new cjs.Rectangle(-43.6,-33.6,152.9,103.9), null);


(lib.Symbol52 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#FFCCFF").ss(2,1,1).p("AgVAAIABAAIAqAA");
	this.shape.setTransform(21.525,35.025);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f().s("#000000").ss(1,1,1,3,true).p("AgPEWIAAAAIAEgFIAqAAIAtAsIAWgBIAQAUQApgDABAQQAKgYAeABQAYA+AegNQARAsAiAAIADghIAfgBIABApIAMgCIAAAMIAjAAIADgJIAGgDIABgIIAUgBIABgKIAdAAIAAgLIAVAAIgBgjIgJAAIgBgKIgLAAIAAhOIhDgEIAAg1IASAAIAAgOIgKgCIABgfIgLAAQACgIgBgOIAVAAIAAgLIAmAAIABgJIAUgBQALgbAIgdQBagNAMiVQAOABgCgpIgxgvQgFgFg0AFQgpg7gYAvIhbAAQAAAUiOAzIglgBIgCgsQhWgVgQhAQgOgHgKgPIgggcQgWgUg/gVQgegtgtgtIgLAKIgnAAIgQgMIgXABIgLAKIgnAAIgEALIhPACIAQAlIhBAAIgPgLIggAHIg5BCIglgCIABA5QARAhArgLIAxAuIA+AhIgCAzIAXAUAltg9IgSAdIgegCIg+A3IAUArIgBBaIAVAdIgVAYIABAuQAKAVAMANQAVAVAdgBIABAEQAQAlBQgNIADA+QBMAMAOAXIAFACIA3gZIAdgjIAAg7IA0ABIAlgmIgHgOIgHgcIhRgpIhKhEIiSimgAmIhVIAbAY");
	this.shape_1.setTransform(58.7375,43.625);

	this.shape_2 = new cjs.Shape();
	this.shape_2.graphics.f("#C55FDE").s().p("AA0D2QgOgXhLgMIgDg+QhQANgQglIgBgEQgdABgVgVQgMgNgKgVIgBguIAVgXIgVgdIABhaIgUgrIA+g4IAeACIASgdIAjAWICRCnIBKBDIBRApIAHAcIAHAOIglAmIg0gBIAAA7IgdAjIg3AZg");
	this.shape_2.setTransform(34.125,62.225);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_2},{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol52, new cjs.Rectangle(-1,-1,119.5,89.3), null);


(lib.sprite1179 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.sprite1160 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.sprite1115 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.sprite1021 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.sprite1018 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.sprite968 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.sprite941 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.text = new cjs.Text("Manipur", "bold 12px 'Arial'");
	this.text.lineHeight = 14;
	this.text.lineWidth = 54;
	this.text.parent = this;
	this.text.setTransform(47.75,-0.25);

	this.timeline.addTween(cjs.Tween.get(this.text).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.sprite941, new cjs.Rectangle(45.8,-2.2,57.7,31.4), null);


(lib.sprite925 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.sprite907 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.sprite864 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.sprite834 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.sprite815 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.sprite756 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.sprite698 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.sprite545 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.sprite88 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.sprite87 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.shape1132UpOverDownHit = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("AAohTQgmgQgYg9IgfgGIgKACIgBATIAKAEIABAaIg6ACIgBgMIgggJIgnABIgBAKIgdgBQgNAHgOAHIgWAcIAJARIACAWIgLAJIAAAMIAKAHIgEAeIgFABIAHgBIANA+IBwBCIAcADIAGAVIDGAAIA5gZQArACAMgdIAMgwQARgCATgJQgGgGABgFQglgcgKgMQgUAFgOgFQgdgggcgSIgogng");
	this.shape.setTransform(0.5,0.475);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#993333").s().p("AhlCSIgcgDIhwhCIgMg+IgIABIAGgBIADgeIgKgHIAAgMIALgJIgCgWIgJgRIAWgcIAbgOIAdABIACgKIAmgBIAgAJIACAMIA5gCIgBgaIgKgEIABgTIAKgCIAfAGQAYA9AlAQIApgBIAoAnQAcASAdAgQAOAFAUgFQAKAMAlAcQgCAFAHAGQgTAJgRACIgMAwQgMAdgrgCIg6AZIjFAAg");
	this.shape_1.setTransform(0.5,0.475);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-26.8,-17.2,54.6,35.4);


(lib.shape1096UpOverDownHit = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("AEcnVIgcACIgKgfIgNAAIg7hIIgdA0IgtAvQgtAJgtAVIgbArQghgDhCABQAjAnAaAWIgNAcIiDCUIgbgSIhBBlIAbAWIgfASIABAyIATAUIgLALIAAAcIALAJIABAWIgfAfIAAAQIAUAOIABAUIgMAKIABAKIA8A7IAAAWIgNAHIgcAAIgJgJIgeAdIgBAOIgIAIIgBAxIgUAWIAqAeIARAAIAVARIgBAKIAMAMIgMALIAzAnIAAAnIALALIBCAAIAYgsIABgcIBEhGIAAgTIAygrIgeicIgeggIgBgIIAWgUIAHAAIApAoIApABIAUATIALAAIAIgOIAAgPIgIgMIgXgBIgcgcIAAg7IgLgNIAAgJIgKgKIAAgKIgJgJIASgVIAMAAIAdgcIAAgLIANgLIBOAAIASgSIAAgfIAMgJIAnhIIABgvIAIgMIANgCIA5g6IAAgIIArgyIgzg9g");
	this.shape.setTransform(34.575,57.1);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#D6AE52").s().p("AjMI7IgLgMIAAgmIgzgoIAMgLIgMgLIABgJIgVgSIgRAAIgqgeIAUgWIABgxIAIgIIABgOIAegdIAJAJIAcAAIANgIIAAgVIg8g7IgBgLIAMgJIgBgUIgUgOIAAgRIAfgeIgBgWIgLgIIAAgdIALgLIgTgUIgBgyIAfgSIgbgWIBBhkIAbARICDiUIANgcQgagWgjgnQBCgBAhADIAbgqQAtgWAtgIIAtgwIAdg0IA7BJIANAAIAKAeIAcgCIALA+IAzA8IgrAyIAAAIIg5A6IgNACIgIAMIgBAvIgnBIIgMAJIAAAfIgSASIhOAAIgNALIAAAMIgdAbIgMAAIgSAVIAJAJIAAALIAKAJIAAAJIALANIAAA7IAcAcIAXABIAIAMIAAAPIgIAOIgLAAIgUgUIgpgBIgpgnIgHAAIgWAUIABAIIAeAfIAeCeIgyAqIAAATIhEBGIgBAcIgYAsg");
	this.shape_1.setTransform(34.575,57.1);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-1,-1,71.2,116.2);


(lib.shape1045UpOverDownHit = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("AA0AQIAHAHIgBASIAMAHIABANQgHADgEAQIgpgNQgcAggrgLIgGgOIgBgPIgLAAIAAgdIALgTIAJgJIAAg+IAfgSIAdgBIABgLIAZACIAYARIgIAMIABAvIAFAJg");
	this.shape.setTransform(7.125,9.1063);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#137175").s().p("Ag0BYIgGgOIgBgPIgLAAIAAgdIALgTIAJgJIAAg+IAfgSIAdgBIABgLIAZACIAYARIgIAMIABAvIAFAJIgGATIAHAHIgBASIAMAHIABANQgHADgEAQIgpgNQgVAYgdAAQgKAAgLgDg");
	this.shape_1.setTransform(7.125,9.1063);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-1,-1,16.3,20.2);


(lib.shape1034UpOverDownHit = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("ADzAsIglhHIg8ADIgOgVQAcgRgMggIgUAJIg0AAIhHA8IghAAIgWgTIg7AAIgOgLIgPgBIgMALIg6AAIgJALIgJAFIgBAOIgIAEIgHAKIAFA7IBFAeIAdgDIAAAJIBJABIABgKICGgBIAAgKIAfgBIABgJIA8AAIACAKIAUABIABAKIAbgCg");
	this.shape.setTransform(24.3,9.5);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#00FF00").s().p("AiLBeIAAgJIgdADIhFgfIgFg6IAHgKIAIgEIABgOIAJgFIAJgLIA7AAIALgLIAPABIAOALIA7AAIAWATIAhAAIBHg7IA0AAIAUgKQAMAggdARIAPAVIA7gDIAmBHIggAnIgbACIAAgLIgUAAIgDgKIg8gBIgBAKIgfABIAAAJIiGACIgBAKg");
	this.shape_1.setTransform(24.3,9.5);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-1,-1,50.6,21);


(lib.shape954UpOverDownHit = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("AAhi7IgCgKIgMgSIgEANIgPAGIgMgIIgIAAIgIAdIgWAXIgYgDIgZAnIAJAKIAABcIASgBIApCGIgJAWIgBAWIA8A1IAigBIAagkIAAgfIgTgEIgBhZIAdgYIABgbIALgGIgChPIgJgFIAAgRIgKgCIgBgRIgJgDIgCgVIgBAAIgagdIAAgMg");
	this.shape.setTransform(10.025,21.6);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#FFFF00").s().p("AgpCjIABgWIAJgWIgpiFIgSABIAAhcIgJgLIAZgnIAYADIAWgXIAIgdIAIAAIAMAIIAPgFIAEgOIAMATIACAKIAHAAIAAALIAaAdIABAAIACAWIAJACIABASIAKABIAAASIAJAEIACBPIgLAGIgBAbIgdAZIABBZIATADIAAAfIgaAkIgiABg");
	this.shape_1.setTransform(10.025,21.6);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-1,-1,22.1,45.2);


(lib.shape938UpOverDownHit = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("ABeh9IgIAAIAAgwIggASIAAAdIgUABIgIgLIgwABIgNASIgHACIgEAUIgUAQIAAADIgFABIgEgBIgbABIABAxIgiAnIACA0IgLAHIABAOIAMAGIACAKIAGAAIABAMIAaAdIAOAAIACAJIARABIABAKIA8gCIgBANIA5gBIABg8IAJAAIABgfIAKgCIAAgSIAKgBIABgIIA7gBIgBgQIgKABIABgyIgMABIAAgxIgJgCIAAgIIgJgCIgBgTIgJgBIABgVg");
	this.shape.setTransform(14.5,17.425);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#008400").s().p("AgCChIg7ACIgBgKIgSgBIgCgJIgOAAIgagdIAAgMIgHAAIgCgKIgMgGIgBgOIALgHIgBg0IAhgnIgBgxIAbgBIAFABIAEgBIAAgDIAUgQIAEgUIAHgCIAMgSIAxgBIAIALIAVgBIAAgdIAegSIABAwIAIAAIABALIAAAVIAIABIABATIAJACIAAAIIAJACIABAxIAMgBIgCAyIALgBIABAQIg8ABIAAAIIgKABIAAASIgKACIgBAfIgJAAIAAA8Ig6ABg");
	this.shape_1.setTransform(14.5,17.425);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-1,-1,31,36.9);


(lib.shape921UpOverDownHit = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("ACfiBIgKAFIABAZIgLADIgBAcIgKACIABASIgLACIAAASIgJACIAAAdIgLAAIgBAKIgJAAIAAATIgLAAIABATIgLABIABAUIgKABIAAAnIgLABIAAAKIgIAAIgBATIgTAEIgCgLIgHAAIgBgxIgeATIAAAdIgUABIgIgMIgyACIgMARIgHADIgEAUIgUAQIgGgBIgDgUIAAgaIgJgFIABghIARgVIASAAQgBAIAFADQAGgCAHACQAEgDAFAAIgCgRQAAgRAIgHQgBgaA5g4QgJgGARgSQAZgaBPgzQArgNAVgaIAVAhg");
	this.shape.setTransform(16.075,18.05);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#0000FF").s().p("AiUC0IgDgUIAAgaIgJgFIABghIARgVIASAAQgBAIAFADQAGgCAHACQAEgDAFAAIgCgSQAAgQAIgHQgBgaA5g3QgJgHARgRQAZgaBPg0QArgNAVgaIAVAhIgCASIgKAFIABAZIgLADIgBAcIgKADIABARIgLADIAAARIgJACIAAAdIgLAAIgBAJIgJAAIAAAUIgLAAIABAUIgLAAIABAUIgKAAIAAAoIgLABIAAAKIgIAAIgBAUIgTACIgCgKIgHAAIgBgwIgeASIAAAdIgUABIgIgLIgyABIgMASIgHACIgEATIgUAQg");
	this.shape_1.setTransform(16.075,18.05);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-1,-1,34.2,38.1);


(lib.shape919 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#FFFFFF").ss(1,1,1,3,true).p("ACfiBIgKAFIABAZIgLADIgBAcIgKACIABASIgLACIAAASIgJACIAAAdIgLAAIgBAKIgJAAIAAATIgLAAIABATIgLABIABAUIgKABIAAAnIgLABIAAAKIgIAAIgBATIgTAEIgCgLIgHAAIgBgxIgeATIAAAdIgUABIgIgMIgyACIgMARIgHADIgEAUIgUAQIgGgBIgDgUIAAgaIgJgFIABghIARgVIASAAQgBAIAFADQAGgCAHACQAEgDAFAAIgCgRQAAgRAIgHQgBgaA5g4QgJgGARgSQAZgaBPgzQArgNAVgaIAVAhg");
	this.shape.setTransform(16.075,18.05);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#E6E6E6").s().p("AiUC0IgDgUIAAgaIgJgFIABghIARgVIASAAQgBAIAFADQAGgCAHACQAEgDAFAAIgCgSQAAgQAIgHQgBgaA5g3QgJgHARgRQAZgaBPg0QArgNAVgaIAVAhIgCASIgKAFIABAZIgLADIgBAcIgKADIABARIgLADIAAARIgJACIAAAdIgLAAIgBAJIgJAAIAAAUIgLAAIABAUIgLAAIABAUIgKAAIAAAoIgLABIAAAKIgIAAIgBAUIgTACIgCgKIgHAAIgBgwIgeASIAAAdIgUABIgIgLIgyABIgMASIgHACIgEATIgUAQg");
	this.shape_1.setTransform(16.075,18.05);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-1,-1,34.2,38.1);


(lib.shape903UpOverDownHit = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("Ag2g+QAfBWApA3IAlghIgNh8IgmAjIgTgTg");
	this.shape.setTransform(39.25,59.65);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#B5FF00").s().p("Ag3g+IAoAAIATATIAmgjIAOB8IgmAhQgpg4gghVg");
	this.shape_1.setTransform(39.25,59.65);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(32.7,50.8,13.099999999999994,17.799999999999997);


(lib.shape900 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("EgW7At8IAAKZItDAAMAAAhyhIOEAAMAAAAo3QI7rLNzAAQHqAAG4DIQG0DDEcFoQEYFjCgH5QCgH4AAI/QAAVVqjLpQqjLpuxAAQurAAoXsRgAwWo5QmvH+AAPJQABO7EDGpQGpK3LWAAQJMAAGun+QGvoDAAv3QAAwPmbnvQmenvpJAAQpNAAmuIDg");
	this.shape.setTransform(297.25,-360.5);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(67,-733,460.5,745);


(lib.shape899 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("EgS8AnnQmai0jDkOQjIkThPmLQg3kJAAo/MAAAgzZIOEAAMAAAAuAQAALBA3D1QBVFjETDNQESDIGVAAQGVAAFjjNQFijSCXljQCRlogBqoMAAAgscIOEAAMAAABS9IskAAIAAsMQptOEwoAAQnVAAmWi0g");
	this.shape.setTransform(280.75,-259.5);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(65.5,-531,430.5,543);


(lib.shape896 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("EgeRAuuQqOrkAA0oQAA1FJ6q8QJ7rBPLAAQN4AAKLLkMAAAgpQIV9AAMAAAByhI0ZAAIAAsMQlGHHm3DhQm9DcnCAAQuSAAqLrfgAswldQlUGKgBMWQABNSDqF8QFUImJiAAQHlAAFTmaQFVmfgBs0QAAuTlJmPQlLmVoCAAQnzAAlPGQg");
	this.shape.setTransform(301.25,-360.5);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(42,-733,518.5,745);


(lib.shape895 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("EgIKA2sQm8jmlBm9IAAMMI0ZAAMAAAhyhIV9AAMAAAApQQKKrkN5AAQPKAAJ8LBQJ7K8gBUiQAAVQqFLfQqJLfueAAQnFAAm5jhgAteliQlPGFAAMgQABM5EEGLQFtIwJcAAQHRAAFKmLQFEmQAAtXQABuOlLmPQlJmVoCAAQn6AAlPGLg");
	this.shape.setTransform(326.75,-360.5);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(67.5,-733,518.5,745);


(lib.shape894 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("Egc0A0EQo1nRAArFQAAhGAFhkIZFDDQAoEYCRBoQDICWGtABQImAAETilQC5huBfj2QBBivAAnVIAAsIQp2Ndu/AAQwugBpxuJQnqrLAAwnQAA04KFrBQKArAO7AAQPYAAKANhIAArqIUjAAMAAABKcQAAOsibHSQibHQkYEKQkYEInRCXQnWCVrLAAQ1FAAo1nMgEgMzgkSQlKGGAAMmQAANMFKGLQFFGFHgABQICAAFjmRQFjmUAAsVQAAs6lUmPQlUmRoIAAQn4ABlFGKg");
	this.shape.setTransform(301,-163.75);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(42,-543,518,758.5);


(lib.shape893 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("EgodA6NMAAAhyhIUeAAIAAMMQD/mQGzj6QGzj6IRAAQOdAAKFLVQKFLVAAUPQAAUxqKLkQqKLfudAAQm3AAljivQloivmLmpMAAAApzgEgNbgimQlUGLAAMMQAAN/FjGtQFjGpH9AAQHqAAFFmGQFFmKAAt/QAAtDlPmVQlPmVnuAAQoDAAlUGQg");
	this.shape.setTransform(328.5,-170.5);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(69.5,-543,518,745);


(lib.shape892 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("EAh1A5RMAAAhaJMgWvBaJI2QAAMgWqhaJMAAABaJI1fAAMAAAhyhMAinAAAMAUxBOHMAUjhOHMAisAAAMAAAByhg");
	this.shape.setTransform(426.5,-366.5);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(72.5,-733,708,733);


(lib.shape891 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("EgfhAkaQnam9AAqoQAAnCDWleQDXljGHi4QGAi+LbiMQPXi5F8igIAAiMQABmVjIiqQjJivoqAAQl2AAjTCWQjRCRiDFyIz6jmQDXsCINlyQINlyQKAAQOsAAHMDhQHMDcC+FZQC5FUAAOTIgPZnQgBK8BHFPQBAFKC5F8I1tAAQg3iMhQkTQgjh9gQgoQlnFemaCvQmaCvnQAAQs1AAnWm9gAgvFAQpIB9i1B4QkSDDAAEsQAAEnDbDXQDcDXFUAAQF7AAFaj6QD/i+BPkTQA3i0AAn5IAAkYQkNBapJB9g");
	this.shape.setTransform(285.75,-265.5);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(36.5,-543,498.5,555);


(lib.shape890 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("EggpAxQQrpqEiRzPIWgiMQCCLWGQFUQGLFUKiAAQLLgBFtksQFokwAAmWQAAkDiWi1Qibi4l8iHQkEhbucjmQymkmngmtQqjpeAAtlQAAoxFAnkQE7nrJYj/QJTj+NNAAQVjAAK8JdQK3JdAjPxI3IBCQhfo1k2j1Qk7j7pwABQqFAAltEIQjrCrAAEdQAAEEDcC4QEYDsQ3D/QQ4D+IIEUQIDEOEnHZQEiHWAAK4QAAJ1leInQleImqAENQqAEKu7gBQ1tABrpqBg");
	this.shape.setTransform(335,-366.25);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(37,-745.5,596,758.5);


(lib.shape889 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("A+jdOQoNrVAAxRQAA0nKyrpQKyruQfAAQSgAAKtMRQKtMMgeZOMg2/AAAQAPJxFFFeQFFFZHkAAQFKAADhi0QDhi0BzmQIV4DrQkOMCpEGVQpJGQtrAAQ1oAAqZuJgArQ1UQksFPAFI/MAgzAAAQgPpiksk7QkslAmuAAQnLAAksFPg");
	this.shape.setTransform(280.5629,-265.5);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(32.5,-543,496.20000000000005,555);


(lib.shape888 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("EAP0A5RMAAAgr1QAAtDhQjgQhQjhjIiCQjNiHkwAAQleAAkTCqQkSCqh9FZQiDFTAAKeMAAAApkI19AAMAAAhyhIV9AAMAAAAqHQKpsbOwAAQHlAAGGC0QGGC0DIEYQDCEYBMFUQBFFUAALKMAAAAwrg");
	this.shape.setTransform(314.75,-366.5);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(73,-733,483.5,733);


(lib.shape887 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("EgDlA3HQkxiBiMjIQiRjOg3lYQgtj1AArpMAAAgkLIqFAAIAAxgIKFAAIAAweIWBs0IAAdSIPAAAIAARgIvAAAMAAAAhbQAAKLAeBuQAZBoBkBGQBfBGCMABQDDAAFyiHIB4RBQnqDTpsgBQl8ABkwh+g");
	this.shape.setTransform(172,-353.25);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(15.5,-718.5,313,730.5);


(lib.shape886 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("EAP3AqbMAAAgqWQAAtbhaj6Qhaj/jIiMQjNiMkdAAQlsAAkiDIQkiDIhpFKQhuFKAAN5MAAAAllI19AAMAAAhS9IUZAAIAAMMQK3uEQeAAQHRAAGBCqQGBClDIEEQDDEEBQFKQBLFKAAJnMAAAAzjg");
	this.shape.setTransform(314.5,-271.5);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(72.5,-543,484,543);


(lib.shape885 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("EgVoAmNQqZlKlZp7QlZqAAAuSQAAq8FZqPQFZqPJ7lZQJ2lZMMAAQS0AAMCMRQMCMMAASrQAAS0sHMbQsMMWycAAQrZAAqUlKgAucy5Ql3GkAAMVQAAMWF3GkQF3GkIlAAQImAAF3mkQFymkAAsfQAAsMlymkQl3mkomAAQolAAl3Gkg");
	this.shape.setTransform(315,-265.5);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(41,-543,548,555);


(lib.shape884 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("EAOsA5RMgU2glRIqPKtIAAakI19AAMAAAhyhIV9AAMAAAA8xIZs9NIbCAAI8XeTMAeZA0qg");
	this.shape.setTransform(314,-366.5);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(68.5,-733,491,733);


(lib.shape883 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("A8Rf4Qq3rfAA0UQAA0iK3raQK3rfSgAAQPKAAI/GkQI6GfD6NXI1pD6QhGmfj1jSQj6jSmLAAQoMAAk2FtQk7FoAANSQAAOwFAGGQE7GGIWAAQGQAAD/jhQD/jmBporIVkDrQjXO2piHlQpiHlwBAAQyMAAqyrfg");
	this.shape.setTransform(293,-265.5);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(42.5,-543,501,555);


(lib.shape882 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("EgK9A5RMAAAhS9IV8AAMAAABS9gEgK9gk8IAA0UIV8AAIAAUUg");
	this.shape.setTransform(143.75,-366.5);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(73.5,-733,140.5,733);


(lib.shape881 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("EgjMArrQurvoAA7CQAA8lOxvyQOxv3YDAAQVBAANIMbQH0HWD5NwI25FeQiBo6mblKQmelKpOAAQsvAAn5JJQn+JJAAUeQAAVtH1JOQH0JOMeAAQJPAAGol3QGql3C5slIWaHHQlKSwr8JJQsDJEybAAQ2zAAutvjg");
	this.shape.setTransform(367.75,-366.5);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(48.5,-745.5,638.5,758);


(lib.shape880 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#E6E6E6").s().p("Ag3g9IAngBIAUAUIAmgkIANB8IgmAhQgog4gghUg");
	this.shape.setTransform(52.45,38.45);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(46.9,30.6,11.100000000000001,15.799999999999997);


(lib.shape852 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("EAoDA5RMAAAhf2MghTBf2ItpAAMghJhhfMAAABhfIunAAMAAAhyhIW1AAMAbGBRFQDwLVBtFoQB+mQEJsHMAbbhPrIUZAAMAAAByhg");
	this.shape.setTransform(425.75,-366.5);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(76,-733,699.5,733);


(lib.shape844 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("EAqPAqbMAAAg0QQAAochVjrQhbjwjliRQjmiRk2AAQowAAlyF3QlzFyABM0MAAAAwMIuDAAMAAAg15QgBpYjcksQjbksn1AAQl7AAlBDIQlEDIiSGBQiRGBAALVMAAAArCIuEAAMAAAhS9IMlAAIAALpQD7mGGejrQGgjwIRAAQJPAAF7D1QF2D1CcG4QJ1uiPyAAQMXAAGoG4QGqGzgBOOMAAAA48g");
	this.shape.setTransform(427.25,-271.5);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(67.5,-543,719.5,543);


(lib.shape843 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("EgHBA5RMAAAhS9IODAAMAAABS9gEgHBgpFIAAwLIODAAIAAQLg");
	this.shape.setTransform(113,-366.5);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(68,-733,90,733);


(lib.shape830UpOverDownHit = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.shape772UpOverDownHit = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("AEzmQIgpgoIgVAAIgKAMIgeAAIgVgVIgRAAIgwg3QgxAagvgDQAAAIgLAGIACAFQAGALAQAKQgHAnAHAYIgCAKIAMAKIAAAUIgxAwIAAATIAIAKIABAUIATAZIAAAOIgLAUIgaACIgBAxIAbApIABAUIgKALIAAAKIALAIIAAAVIgeALIAAAmIgIAKIgCAVIhNBEIgWAAIgMALIhEAAIgpApIgTAAIgBgKIgUAAIgdAeIAAASIASAUIAWAAIAbAdIAOADIgCgJIANgBIAHAIIABAUIA8BSIgJAeIAAABIA7AxIAJgOIAVANIAnAnIAAANIAaAEQAqgUAXgyIANgjIABgFIAdAAIgBAFQgCAVAFAOQADAIAHAFIAegBIABgLIATAAIABgKIA9ABIAAhAIgIgCIgDgKIgKgBIABhPIgLAAIABhGIgUgBIAAgoIgJABIgCgKIgUgBIABgSIgJgCIgBgJIgMgBIACgWIAMgDIgDgGIAWgNIgGg5IgsgLIg9gwIABgqQAXACAPgMIAMgLIgDgnQAbAEgEgOIAhAAQgGAMAbgDIAHgeIgMgDIAAgOIgSAAIgLgLIgoABQgKgFgBgWIgTgHQgYgYgKglQAPANAQgnQAZgRgEgRQgYgGAFghIAjACQABAJAHACQADAKAHABQgDAgATAKIAMgIIAKgQIAHgCIACgRIAVgBIABASIALADIADASIAjAhIAcgCIAAgbIAMgBIABgKIAZgEIAEgbIAIgFIABgag");
	this.shape.setTransform(31.425,50.45);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#CECEB5").s().p("AgiH1IAAgOIgngmIgVgMIgJANIg7gxIAAgBIAJgeIg8hTIgBgTIgHgIIgNABIACAJIgOgDIgbgcIgWAAIgSgWIAAgSIAdgdIAUAAIABAKIATAAIApgpIBEAAIAMgMIAWAAIBNhCIACgWIAIgKIAAgmIAegKIAAgWIgLgIIAAgKIAKgLIgBgUIgbgpIABgxIAagCIALgTIAAgPIgTgZIgBgUIgIgJIAAgTIAxgxIAAgUIgMgKIACgKQgHgYAHgnQgQgKgGgKIgCgGQALgGAAgIQAvADAxgaIAwA3IARAAIAVAVIAeAAIAKgMIAVAAIApApIAHgDIgBAaIgIAFIgEAbIgZAEIgBAKIgMABIAAAbIgcACIgjghIgDgSIgLgDIgBgSIgVACIgCAQIgHADIgKAQIgMAIQgTgLADgfQgHgCgDgKQgHgBgBgKIgjgCQgFAhAYAGQAEARgZARQgQAngPgNQAKAlAYAYIATAHQABAWAKAGIAogCIALALIASAAIAAAOIAMADIgHAeQgbADAGgMIghAAQAEAPgbgFIADAoIgMALQgPAMgXgCIgBApIA9AwIAsALIAGA6IgWAMIADAHIgMACIgCAWIAMACIABAJIAJABIgBASIAUABIACAKIAJAAIAAAnIAUABIgBBGIALAAIgBBPIAKABIADAKIAIABIAABBIg9gBIgBAKIgTAAIgBALIgeACQgHgGgDgJQgFgNACgVIABgFIgdAAIgBAFIgNAiQgXAzgqATg");
	this.shape_1.setTransform(31.425,50.45);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-1,-1,64.9,102.9);


(lib.shape752UpOverDownHit = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("AFak/IABAAIgCAxIAcApIABAUIgKALIgBAKIAMAIIAAAVIggALIAAAnIgHAKIgCAVIhNBDIgWAAIgMALIhEAAIgpAoIgTAAIgBgKIgUABIgdAdIAAASIASAVIAWAAIAbAdIAOACIgCgJIANgBIAHAJIABATIA8BTIAAAAIgJAeIgBAAIgeAAIAAAAIgJgLIgVgCIgKgTIgTgBIgKgTIgMAAIgKALIAAATIAKAMIAAASIgcAzIgVggIhtABIgKgHIAAgOIAHgHIANAAIgBgNIgTgRIgXAAIAAAAIgGAIIhHAAIgJAMIgMAAIAAgLIg8AAIATgUIAAgIIArgyIgzg9IgLg9IgcACIgKgfIgNAAIg6hHIAJgIIAAgu");
	this.shape.setTransform(37.5,32.15);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#66FFCC").s().p("AAjEhIhtABIgKgHIAAgOIAIgHIAMgBIgBgMIgTgRIgXAAIAAAAIgFAIIhIAAIgIAMIgNAAIAAgLIg8AAIAUgUIAAgIIAqgyIgzg9IgKg9IgcACIgLgfIgNAAIg6hHIAJgIIAAguIBxgCIAcAVIAagaIAfATQAWgOgBgVIBCADIBIgeQALgcAngNQAwAXAZAdQAKgXAZgPQAagMAhAJQgLgtATg4QBGggA7AIIAAAAIABAAIgCAxIAcApIABAUIgKALIAAAKIALAIIAAAVIggALIAAAnIgHAKIgCAVIhNBDIgWAAIgMALIhFAAIgoAoIgTAAIgBgKIgUABIgdAdIgBASIASAVIAXAAIAbAdIAOACIgCgJIAMgBIAHAJIACATIA8BTIAAAAIgJAeIAAAAIgfAAIgBAAIgIgLIgVgCIgKgTIgTgBIgJgTIgOAAIgJALIAAATIAKAMIAAASIgcAzg");
	this.shape_1.setTransform(37.5,32.07);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-1,-0.8,77,66);


(lib.shape736 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#FFFFFF").ss(1,1,1,3,true).p("AABADIgBgFIgBAA");
	this.shape.setTransform(88.3,-68.3);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f().s("#666666").ss(1,1,1,3,true).p("AAAAAIAAAAIAAAAg");
	this.shape_1.setTransform(15.975,-42.675);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(15,-69.6,74.5,27.999999999999993);


(lib.shape694UpOverDownHit = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("ADVA2IABAoIgNAKIgBAzIAWAnIABA0QgXAHgKAsIgFB4Ig1gBQg0gcAEhpQgzgBgLhyQAqgQgVhBIgtAWIAFhgQgtghgIhjQh5iIgviWIgBAAIgDgKIAEAAIAZACQAmAwAkAFQBMCLAugpQASAiAcAMIARAJQgwAtBCAQIgBAoIAqAOIgEAoIAWAaIgBAcQgkA1A6AMIAxgNIgBgK");
	this.shape.setTransform(12.5,27.95);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#CCFFFF").s().p("ACDGfQgzgbAEhpQgzgBgLhyQAqgQgWhBIgsAWIAGhhQgugggIhjQh5iIgviWIgBAAIgCgKIADAAIAZABQAmAyAkAEQBMCLAvgpQARAiAdAMIAQAJQgwAsBCARIgBAoIApAOIgDAoIAWAaIgBAbQgkA2A6ALIAxgNIABApIgNAKIgBAzIAWAnIAAAzQgWAIgLArIgEB4g");
	this.shape_1.setTransform(12.5,27.95);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-10.7,-14.7,46.5,85.3);


(lib.shape686UpOverDownHit = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#FFFFFF").ss(1,1,1,3,true).p("AABAOIADgDIAAgKIADgSIgNASQACAOAGADg");
	this.shape.setTransform(64.375,30.5);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#E6E6E6").s().p("AgGAAIANgRIgDATIAAAJIgDADIABADQgGgCgCgPg");
	this.shape_1.setTransform(64.375,30.5);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape}]}).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(62.7,27.8,3.3999999999999915,5.4999999999999964);


(lib.shape617 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("Ege2AkuQnWmuAAqZQAAmGC0lAQCvlFEijDQEdjCFohkQEJhGIXhBQRBiCIDi0IAFjrQAAomj/jhQlZkxqnAAQp7AAksDhQkxDciRI1Itwh4QB4o1ETlZQETleIIi5QIIi+KsAAQKoAAGpCgQGpCgDID1QDIDwBQFyQAtDmAAJYIAASvQAATnA8FPQA3FKCqExIusAAQiMkYgol3Qn0GpnMCvQnQCvoSAAQtrAAnWmpgAjbFKQorBQjmBkQjmBkh9DDQh9C+AADrQAAFoETDwQEODwINAAQIHAAGVjhQGVjmC+mLQCRkxAApTIAAlJQnqDHvTCMg");
	this.shape.setTransform(281.5,-265.5);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(37,-543,489,555);


(lib.shape557 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#FFFFFF").ss(1,1,1,3,true).p("AACgCIgDAF");
	this.shape.setTransform(-30.875,6.575);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-32,5.3,2.3000000000000007,2.6000000000000005);


(lib.shape481 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("Aq9K/IAA18IV8AAIAAV8g");
	this.shape.setTransform(143.75,-70.25);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(73.5,-140.5,140.5,140.5);


(lib.shape95 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_2
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#EAF7C3").s().p("AyTH4QhjAAgBh1IAAsFQABh1BjAAMAknAAAQBjAAABB1IAAMFQgBB1hjAAg");
	this.shape.setTransform(0,-33.625);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	// Layer_1
	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#105027").s().p("AyoITQhnAAABh7IAAsuQgBh8BnAAMAlRAAAQBnAAgBB8IAAMuQABB7hnAAg");
	this.shape_1.setTransform(0,-33.675);

	this.timeline.addTween(cjs.Tween.get(this.shape_1).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-129.5,-86.8,259.1,106.3);


(lib.shape82 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#FFEEB9").s().p("EhGTACaIAAk0MCMnAAAIAAE0g");
	this.shape.setTransform(330.3,15.45);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-119.7,0,900,30.9);


(lib.laddakh = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.text = new cjs.Text("Ladakh", "bold 12px 'Arial'");
	this.text.textAlign = "center";
	this.text.lineHeight = 14;
	this.text.alpha = 0.87843137;
	this.text.parent = this;
	this.text.setTransform(64.25,39.6);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#FFCCFF").ss(2,1,1).p("AgVAAIABAAIAqAA");
	this.shape.setTransform(21.525,35.025);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f().s("#000000").ss(1,1,1,3,true).p("AmIhVIAbAYIAjAWICSCmIBKBEIBRApIAHAcIAHAOIAEgFIAqAAIAtAsIAWgBIAQAUQApgDABAQQAKgYAeABQAYA+AegNQARAsAiAAIADghIAfgBIABApIAMgCIAAAMIAjAAIADgJIAGgDIABgIIAUgBIABgKIAdAAIAAgLIAVAAIgBgjIgJAAIgBgKIgLAAIAAhOIhDgEIAAg1IASAAIAAgOIgKgCIABgfIgLAAQACgIgBgOIAVAAIAAgLIAmAAIABgJIAUgBQALgbAIgdQBagNAMiVQAOABgCgpIgxgvQgFgFg0AFQgpg7gYAvIhbAAQAAAUiOAzIglgBIgCgsQhWgVgQhAQgOgHgKgPIgggcQgWgUg/gVQgegtgtgtIgLAKIgnAAIgQgMIgXABIgLAKIgnAAIgEALIhPACIAQAlIhBAAIgPgLIggAHIg5BCIglgCIABA5QARAhArgLIAxAuIA+AhIgCAzIAXAU");
	this.shape_1.setTransform(58.7375,43.625);

	this.shape_2 = new cjs.Shape();
	this.shape_2.graphics.f("#00CCCC").s().p("AFcGoIgMACIgBgpIgfABIgDAhQgiAAgRgsQgeANgYg+QgegBgKAYQgBgQgpADIgQgUIgWABIgtgsIgqAAIgEAFIgHgOIgHgcIhRgpIhKhEIiSimIgjgWIgbgYIArAAIgrAAIgBAAIgXgUIACgzIg+ghIgxguQgrALgRghIgBg5IAlACIA5hCIAggHIAPALIBBAAIgQglIBPgCIAEgLIAnAAIALgKIAXgBIAQAMIAnAAIALgKQAtAtAeAtQA/AVAWAUIAgAcQAKAPAOAHQAQBABWAVIACAsIAlABQCOgzAAgUIBbAAQAYgvApA7QA0gFAFAFIAxAvQACApgOgBQgMCVhaANQgIAdgLAbIgUABIgBAJIgmAAIAAALIgVAAQABAOgCAIIALAAIgBAfIAKACIAAAOIgSAAIAAA1IBDAEIAABOIALAAIABAKIAJAAIABAjIgVAAIAAALIgdAAIgBAKIgUABIgBAIIgGADIgDAJIgjAAg");
	this.shape_2.setTransform(58.7375,43.625);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_2},{t:this.shape_1},{t:this.shape},{t:this.text}]}).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-1,-1,119.5,89.3);


(lib.Symbol128 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.Symbol1063();
	this.instance.setTransform(57.7,85.5,1,1,0,0,0,27.1,92.3);
	this.instance.filters = [new cjs.ColorFilter(0, 0, 0, 1, 0, 51, 204, 0)];
	this.instance.cache(-2,-2,58,189);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(30.6,-6.8,54.1,184.60000000000002);


(lib.Symbol117 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.text = new cjs.Text("Punjab", "bold 12px 'Arial'");
	this.text.textAlign = "center";
	this.text.lineHeight = 14;
	this.text.parent = this;
	this.text.setTransform(18.75,20.4);

	this.instance = new lib.Symbol72();
	this.instance.setTransform(65,29.65,1,1,0,0,0,11.3,11);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("ADTAyIAVAdIATANIgRAOIgFAYIglACIgBAzIgWgBIgIgKIgeAAIgKALIAJAbIgYAVIguACIgCgKIgnADIACAWIgVAAIgFgIIgJAIIgiAAIgCgbQgUADgKggIhGgDIgJgHQg5AHgWgYIgIgNIgEgSQAehAA0grIAggDIAcgfIgYgSQAAgQAOgOIAAgrQgUgRARggIA9goIAkgCIAZgiIA8gYIABA1IAvBZQgIAxA/ALQAPAUAWAIg");
	this.shape.setTransform(62.6,24.825);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#CECEB5").s().p("AAAD4IgFgIIgJAIIgiAAIgDgbQgSADgLggIhGgDIgJgHQg5AHgWgYIgIgNIgEgSQAehAA0grIAhgDIAbgfIgYgSQAAgQAPgOIAAgrQgVgRARggIA8goIAlgCIAZgiIA8gYIABA1IAvBZQgIAxA+ALQAQAUAWAIIAJBDIAXAdIASANIgSAOIgFAYIgkACIgCAzIgVgBIgIgKIgeAAIgLALIAKAbIgXAVIgvACIgCgKIgnADIABAWg");
	this.shape_1.setTransform(62.6,24.825);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.shape},{t:this.instance},{t:this.text}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-3.3,-1,92,51.7);


(lib.Symbol111 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.Tripura();
	this.instance.setTransform(86.55,57.95,0.0713,0.0713,0,180,0);

	this.text = new cjs.Text("Tripura", "bold 12px 'Arial'");
	this.text.lineHeight = 14;
	this.text.lineWidth = 48;
	this.text.parent = this;
	this.text.setTransform(41.6,42.25);

	this.instance_1 = new lib.sprite968();
	this.instance_1.setTransform(0,28.95,0.6,0.6);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#FF0084").ss(2,1,1).p("Ahqi1IAABCIAAEpIDUAA");
	this.shape.setTransform(27.7,30.65);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f().s("#000000").ss(1,1,1,3,true).p("AAshcIAAgDAAshcIAgAmIAABbIAKAAIAIABIgBAQIgUABIAAAIIgeABIAAAKIgTAAIAAAKIgSABIgDAKIgDAAIg0ABIgLgIIAAgXIgeAAIAAhnQATglAXgSg");
	this.shape_1.setTransform(17.125,9.6);

	this.shape_2 = new cjs.Shape();
	this.shape_2.graphics.f("#FF0084").s().p("Ag/BWIAAgXIgeABIAAhnQATglAXgSIBfABIAgAmIAABbIAKgBIAIACIgBAQIgUABIAAAIIgeABIAAAJIgTABIAAAJIgSACIgDAJIgDAAIAAhCIAABCIg0ACg");
	this.shape_2.setTransform(17.125,9.725);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_2},{t:this.shape_1},{t:this.shape},{t:this.instance_1},{t:this.text},{t:this.instance}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(6.8,-1,91,72.7);


(lib.Symbol109 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.Manipur();
	this.instance.setTransform(116.4,4.2,0.0705,0.0705);

	this.instance_1 = new lib.sprite941();
	this.instance_1.setTransform(15.55,6.7);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,1,1,3,true).p("ABWitIggASIAAAdIgUABIgIgLIgwABIgNASIgHACIgEAUIgUAQIAAADIgFABIgEgBIgbABIABAxIgiAnIACA0IgLAHIABAOIAMAGIACAKIAGAAIABAMIAaAdIAOAAIACAJIARABIABAKIA8gCIgBANIA5gBIABg8IAJAAIABgfIAKgCIAAgSIAKgBIAAgDIABgFIA7gBIgBgQIgKABIABgyIgMABIAAgxIgJgCIAAgIIgJgCIgBgTIgJgBIABgVIgCgLIgIAAg");
	this.shape.setTransform(14.5,17.425);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f().s("#008400").ss(2,1,1).p("AGkAAItHAA");
	this.shape_1.setTransform(65.0625,23.2);

	this.shape_2 = new cjs.Shape();
	this.shape_2.graphics.f("#008400").s().p("AgCChIg7ACIgBgKIgSgBIgCgJIgOAAIgagdIAAgMIgHAAIgCgKIgMgGIgBgOIALgHIgBg0IAhgnIgBgxIAbgBIAFABIAEgBIAAgDIAUgQIAEgUIAHgCIAMgSIAxgBIAIALIAVgBIAAgdIAegSIABAwIAIAAIABALIAAAVIAIABIABATIAJACIAAAIIAJACIABAxIAMgBIgCAyIALgBIABAQIg8ABIAAAFIAAADIgKABIAAASIgKACIgBAfIgJAAIAAA8Ig6ABg");
	this.shape_2.setTransform(14.5,17.425);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_2},{t:this.shape_1},{t:this.shape},{t:this.instance_1},{t:this.instance}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-1,-1,147.3,36.9);


(lib.Symbol104 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.shape1045UpOverDownHit("synched",0);
	this.instance.setTransform(8.4,33.75);

	this.instance_1 = new lib.Sikkim();
	this.instance_1.setTransform(0,0.5,0.0959,0.0959);

	this.text = new cjs.Text("Sikkim", "bold 12px 'Arial'");
	this.text.lineHeight = 14;
	this.text.lineWidth = 45;
	this.text.parent = this;
	this.text.setTransform(21.55,2);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#137175").ss(2,1,1).p("ACYhvIAADfACWBvIktAA");
	this.shape.setTransform(29.775,29.325);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape},{t:this.text},{t:this.instance_1},{t:this.instance}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,68.4,53);


(lib.Symbol97 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.Kerala();
	this.instance.setTransform(0,42.5,0.0364,0.0364);

	this.text = new cjs.Text("Kerela", "bold 12px 'Arial'");
	this.text.lineHeight = 14;
	this.text.lineWidth = 45;
	this.text.parent = this;
	this.text.setTransform(19.5,41.4);

	this.instance_1 = new lib.shape694UpOverDownHit("synched",0);
	this.instance_1.setTransform(79.7,13.7);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#CCFFFF").ss(2,1,1).p("AGDAAIsFAA");
	this.shape.setTransform(59.3,57.35);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape},{t:this.instance_1},{t:this.text},{t:this.instance}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,-1,115.5,85.3);


(lib.Symbol95 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.Chhattisgarh();
	this.instance.setTransform(191.05,72.65,0.1476,0.1476);

	this.text = new cjs.Text("Chattisgarh", "bold 12px 'Arial'");
	this.text.lineHeight = 14;
	this.text.lineWidth = 72;
	this.text.parent = this;
	this.text.setTransform(118.05,76.35);

	this.instance_1 = new lib.shape1096UpOverDownHit("synched",0);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_1},{t:this.text},{t:this.instance}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-1,-1,214.2,116.2);


(lib.Symbol94 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.WestBengal();
	this.instance.setTransform(20.8,67.55,0.1201,0.1201);

	this.text = new cjs.Text("West Bengal", "bold 12px 'Arial'");
	this.text.lineHeight = 14;
	this.text.parent = this;
	this.text.setTransform(62.15,108.7);

	this.instance_1 = new lib.shape772UpOverDownHit("synched",0);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#CECEB5").ss(2,1,1).p("AhqjdIAAG7IDUAA");
	this.shape.setTransform(52.2,96.85);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape},{t:this.instance_1},{t:this.text},{t:this.instance}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-1,-1,137.4,125.4);


(lib.Symbol93 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.Jharkhandlogo();
	this.instance.setTransform(39.2,102.85,0.0749,0.0749);

	this.text = new cjs.Text("Jharkhand", "bold 10px 'Arial'");
	this.text.lineHeight = 11;
	this.text.parent = this;
	this.text.setTransform(23.65,90.4);

	this.instance_1 = new lib.shape752UpOverDownHit("synched",0);
	this.instance_1.setTransform(17.85,67.65);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_1},{t:this.text},{t:this.instance}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(16.9,66.8,77,66.00000000000001);


(lib.Symbol91 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.text = new cjs.Text("Uttarakhand", "bold 12px 'Arial'", "#231F23");
	this.text.lineHeight = 16;
	this.text.parent = this;
	this.text.setTransform(54.9,9.4);

	this.instance = new lib.Uttarakhand();
	this.instance.setTransform(12.5,6,0.15,0.15);

	this.instance_1 = new lib.shape1132UpOverDownHit("synched",0);
	this.instance_1.setTransform(25.8,16.25);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#993333").ss(2,1,1).p("AFhAAIrBAA");
	this.shape.setTransform(73.175,22.8);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape},{t:this.instance_1},{t:this.instance},{t:this.text}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-1,-1,128.1,35.5);


(lib.Symbol87 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 2
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("AmBCQIAAkfIMDAAIAAEfg");
	this.shape.setTransform(35.7,12.7);
	this.shape._off = true;

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(3).to({_off:false},0).wait(1));

	// Layer 1
	this.instance = new lib.Goa();
	this.instance.setTransform(0,1.05,0.0713,0.0713);

	this.text = new cjs.Text("Goa", "bold 12px 'Arial'");
	this.text.lineHeight = 14;
	this.text.lineWidth = 33;
	this.text.parent = this;
	this.text.setTransform(16.85,2);

	this.instance_1 = new lib.shape903UpOverDownHit("synched",0);
	this.instance_1.setTransform(23.8,-49.9);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f().s("#B5FF00").ss(2,1,1).p("ADsAAInXAA");
	this.shape_1.setTransform(41.325,16.3);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.instance_1},{t:this.text},{t:this.instance}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-2.9,-1.7,77.2,33.1);


(lib.Symbol85 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{andman:1,andhraPradesh:2,arunachalPradesh:3,assam:4,bihar:5,maharashtra:6,chandigarh:8,chattisgarh:9,dadra:10,daman:11,delhi:12,goa:13,gujrat:14,haryana:15,himachal:16,j_k:17,jharkhand:18,karnataka:19,kerela:20,lakshadweep:21,madhyaPradesh:22,manipur:24,punjab:25,mizoram:26,nagaland:27,orissa:28,ladakh:29,meghalaya:30,rajsthan:31,sikkim:32,tamilNadu:33,telangana:34,tripura:35,utterPradesh:36,uttarakhand:37,westBangal:38,puducherry:39});

	// timeline functions:
	this.frame_0 = function() {
		this.stop()
	}

	// actions tween:
	this.timeline.addTween(cjs.Tween.get(this).call(this.frame_0).wait(41));

	// Layer_1
	this.text = new cjs.Text("Andaman & Nicobar SDA\nOffice of Executive Engineer,\nNRSE Division (Behind Ganesh Temple)\nElectricity Department Pratrapur\nPort Blair - 744105.", "12px 'Arial'");
	this.text.lineHeight = 13;
	this.text.lineWidth = 221;
	this.text.parent = this;
	this.text.setTransform(-369.4947,-38.4652,1.3973,1.3973);

	this.instance = new lib.shape95("synched",0);
	this.instance.setTransform(-216.85,46.9,1.2431,1.0813,0,0,0,-0.1,0.1);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[]}).to({state:[{t:this.instance,p:{regX:-0.1,regY:0.1,scaleX:1.2431,scaleY:1.0813,x:-216.85,y:46.9}},{t:this.text,p:{scaleX:1.3973,scaleY:1.3973,x:-369.4947,y:-38.4652,text:"Andaman & Nicobar SDA\nOffice of Executive Engineer,\nNRSE Division (Behind Ganesh Temple)\nElectricity Department Pratrapur\nPort Blair - 744105.",lineWidth:221}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:0,scaleX:1.386,scaleY:1.0383,x:-385.75,y:-10.15}},{t:this.text,p:{scaleX:1.386,scaleY:1.386,x:-554.1719,y:-91.3447,text:"State Energy Conservation Mission (SECM)\n2nd Floor, 33/11 kV Indoor Substation, Museum Road,\nGovernerpet,\nVijayawada â€“ 520 002, Andhra Pradesh.",lineWidth:247}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:0,scaleX:1.3821,scaleY:1.0457,x:-210.35,y:-171.8}},{t:this.text,p:{scaleX:1.3821,scaleY:1.3821,x:-378.2642,y:-253.6877,text:"Arunachal Pradesh Renewable Energy Development Agency\nUrja Bhawan, Post Box-124\nTadar Tang Marg, VIP Road\nNiti Vihar,Itanagar - 791 111",lineWidth:247}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:0,scaleX:1.4398,scaleY:1.0433,x:-219.5,y:-188.9}},{t:this.text,p:{scaleX:1.4398,scaleY:1.4398,x:-394.4296,y:-270.3416,text:"Chief Electrical Inspector â€“cum- Adviser\nGovernment of Assam\n1st floor, West End Block, Housefed Complex,\nBasistha Road, Dispur,\nGuwahati â€“ 781 003, Assam.",lineWidth:247}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:0,scaleX:1.3552,scaleY:0.9618,x:-57,y:-42.8}},{t:this.text,p:{scaleX:1.5558,scaleY:1.5558,x:-219.9615,y:-116.8504,text:"Bihar Renewable Energy Development Agency (BREDA),\n2nd Floor, Vidhyut Bhawan-II, \nBailey Road, Patna â€“ 800001  ",lineWidth:210}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:0,scaleX:1.5249,scaleY:1.1511,x:-144.75,y:-77.7}},{t:this.text,p:{scaleX:1.5249,scaleY:1.5249,x:-328.1998,y:-167.4448,text:"Maharashtra Energy Development Agency (MEDA)\nMHADA Commercial Complex, 2nd Floor, Opp. Tridal Nagar,\nYerwada, Pune â€“ 411 006, Maharashtra",lineWidth:222}}]},1).to({state:[]},1).to({state:[{t:this.instance,p:{regX:-0.1,regY:-0.1,scaleX:1.3833,scaleY:1.0132,x:-128.8,y:-224.85}},{t:this.text,p:{scaleX:1.6259,scaleY:1.6259,x:-294.7517,y:-303.3765,text:"Electrical Circle, Room No. 523,\n5th Floor, Deluxe Building, U.T Sectt.\nSector 9-D, \nChandigarh â€“ 160 009.",lineWidth:210}}]},1).to({state:[{t:this.instance,p:{regX:-0.1,regY:-0.3,scaleX:1.5482,scaleY:1.2963,x:-53.35,y:-94.55}},{t:this.text,p:{scaleX:1.7508,scaleY:1.7508,x:-236.5015,y:-195.6014,text:"Chhattisgarh State Renewable Energy Development Agency (CREDA)\nVIP Road (Airport Road), Near \nEnergy Education Park,\nRaipur â€“ 492 015, Chhattisgarh.",lineWidth:210}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:0,scaleX:1.5133,scaleY:0.9423,x:-211.75,y:14.95}},{t:this.text,p:{scaleX:1.5133,scaleY:1.5133,x:-395.6266,y:-57.674,text:"Dadra Nagar Haveli Power Distribution Corporation Limited,Vidyut Bhavan, Near Secretariat, 66KV Road,Amli, Silvassa - 396230.",lineWidth:243}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:0,scaleX:1.4516,scaleY:1.0664,x:-200,y:-44.25}},{t:this.text,p:{scaleX:1.4516,scaleY:1.4516,x:-376.3531,y:-127.5128,text:"Electricity Department,\n4th Floor, Vidyut Bhavan, Near 66/11 KV Kachigam Sub-Station,\nSomnath - Kachigam Road,\nKachigam â€“ 396 210, Daman.",lineWidth:222}}]},1).to({state:[{t:this.instance,p:{regX:-0.1,regY:-0.1,scaleX:1.4394,scaleY:1.1433,x:-130.05,y:-196.75}},{t:this.text,p:{scaleX:1.5288,scaleY:1.5288,x:-304.0576,y:-286.0518,text:"Energy Efficiency and Renewable Energy Management Centre\n2nd Floor, E-Block, Vikas Bhawan - II, Near GPO Building,\nCivil Lines, New Delhi â€“ 110 055.",lineWidth:234}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:0,scaleX:1.5596,scaleY:0.7607,x:-176.1,y:46.2}},{t:this.text,p:{scaleX:1.5596,scaleY:1.5596,x:-365.6193,y:-10.8573,text:"Electricity Department, Government of Goa\n2nd floor, Vidyut Bhawan,\nPanaji â€“ 403001, Goa.",lineWidth:245}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:0,scaleX:1.5712,scaleY:0.9552,x:-185.85,y:-146.25}},{t:this.text,p:{scaleX:1.5712,scaleY:1.5712,x:-376.7424,y:-219.6282,text:"Gujarat Energy Development Agency (GEDA)\n4th floor, Block No. 11 & 12,\nUdyog Bhavan, Sector-11, Gandhinagar â€“ 382017, Gujarat.",lineWidth:244}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:0,scaleX:1.4974,scaleY:1.1223,x:-135.25,y:-221.6}},{t:this.text,p:{scaleX:1.4974,scaleY:1.4974,x:-317.1947,y:-309.3952,text:"Renewable Energy Department, Haryana & HAREDA,\nAkshay Urja Bhawan, Institutional Plot No.1, Sector 17,\nPanchkula â€“ 134109, Haryana.",lineWidth:255}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:0,scaleX:1.2911,scaleY:0.7732,x:-136.1,y:-217.75}},{t:this.text,p:{scaleX:1.5964,scaleY:1.5964,x:-290.4927,y:-275.7735,text:"Directorate of Energy (GoHP),\nPhase-III, Sectror-VI, New Shimla,\nHimachal Pradesh â€“ 171009.",lineWidth:200}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:0,scaleX:1.5712,scaleY:0.7577,x:-98.35,y:-227.1}},{t:this.text,p:{scaleX:1.5712,scaleY:1.5712,x:-289.2924,y:-283.8782,text:"Commercial and Survey Power Development Department Complex Bemina,\n Srinagar â€“ 190 008,Jammu & Kashmir.",lineWidth:241}}]},1).to({state:[{t:this.instance,p:{regX:-0.1,regY:-0.1,scaleX:1.3975,scaleY:0.9843,x:-401.9,y:-120.65}},{t:this.text,p:{scaleX:1.3975,scaleY:1.3975,x:-571.545,y:-197.5655,text:"Jharkhand Renewable Energy Development Agency (JREDA)\n3rd Floor, SLDC Building, Kusai Colony, Doranda,\nRanchi â€“ 834 002, Jharkhand.",lineWidth:243}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:0,scaleX:1.4593,scaleY:1.0822,x:-144.8,y:37.35}},{t:this.text,p:{scaleX:1.4593,scaleY:1.4593,x:-322.1186,y:-47.1767,text:"Karnataka Renewable Energy Development Limited (KREDL)\n39, Shanthi Gruha, Bharath Scouts & Guides Building, Palace Road, Bengaluru â€“ 560 001, Karnataka.",lineWidth:243}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:0,scaleX:1.5635,scaleY:0.7536,x:-144.2,y:99.9}},{t:this.text,p:{scaleX:1.5635,scaleY:1.5635,x:-334.177,y:43.2857,text:"Energy Management Centre (EMC) - Kerala,\nSreekrishna Nagar, Sreekaryam,\nThiruvananthapuram â€“ 695 017, Kerala.",lineWidth:243}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:0.1,scaleX:1.8468,scaleY:0.9453,x:-249.65,y:134.9}},{t:this.text,p:{scaleX:1.7493,scaleY:1.7493,x:-474.7985,y:63.2013,text:"Electricity Division Office\nLakshadweep Electricity Department \nKavaratti Island, UT of Lakshadweep â€“ 682 555.",lineWidth:256}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:0,scaleX:1.6291,scaleY:0.772,x:-89.25,y:-154.65}},{t:this.text,p:{scaleX:1.6291,scaleY:1.6291,x:-287.2082,y:-212.4824,text:"M.P. Urja Vikas Nigam Limited\nUrja Bhawan, Link Road No. 2, Shivaji Nagar,Bhopal â€“ 462 016, Madhya Pradesh.",lineWidth:247}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:0,scaleX:1,scaleY:0.7392,x:-209.25,y:-76.4}},{t:this.text,p:{scaleX:1,scaleY:1,x:-330.75,y:-134.2,text:"Maharashtra Energy Development Agency (MEDA)\nMHADA Commercial Complex, 2nd Floor, Opp. Tridal Nagar,\nYerwada, Pune â€“ 411 006, Maharashtra.",lineWidth:239}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:0,scaleX:1.3782,scaleY:1.1879,x:-34.35,y:-26.65}},{t:this.text,p:{scaleX:1.3782,scaleY:1.3782,x:-201.8065,y:-120.5808,text:"Manipur State Power Distribution Company Limited (MSPDCL),\n3rd Floor, New Directorate Building (Near 2nd M.R. Gate)\nImphal-Dimapur Road,\nImphal â€“ 795 001, Manipur.",lineWidth:239}}]},1).to({state:[{t:this.instance,p:{regX:-0.1,regY:-0.1,scaleX:1.4091,scaleY:1.0679,x:-149.95,y:-188.35}},{t:this.text,p:{scaleX:1.4091,scaleY:1.4091,x:-321.0182,y:-272.9864,text:"Punjab Energy Development Agency (PEDA)\nSolar Passive Complex,Plot No. 1-2, Sector 33-D,\nChandigarh (U.T.) â€“ 160 034.",lineWidth:239}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:-0.1,scaleX:1.3052,scaleY:1.0115,x:-254.05,y:-53.6}},{t:this.text,p:{scaleX:1.3568,scaleY:1.3568,x:-412.1636,y:-133.1422,text:"Chief Electrical Inspector\nPower & Electricity Department, Electrical Inspectorate\nGovernment of Mizoram, Zuangtui,\nAizawl â€“ 796 017, Mizoram.",lineWidth:239}}]},1).to({state:[{t:this.instance,p:{regX:-0.1,regY:-0.1,scaleX:0.9983,scaleY:0.9326,x:-161.45,y:-137.05}},{t:this.text,p:{scaleX:1.5092,scaleY:1.5092,x:-278.4684,y:-209.8166,text:"Senior Electrical Inspector\nOld Assembly Secretariat\nNear Old Assembly Hostel,\nKohima â€“ 797 001, Nagaland.",lineWidth:161}}]},1).to({state:[{t:this.instance,p:{regX:-0.1,regY:-0.1,scaleX:1.3165,scaleY:1.2821,x:-82.55,y:-116.05}},{t:this.text,p:{scaleX:1.3165,scaleY:1.3165,x:-241.0829,y:-216.6196,text:"Engineer- In-Chief (Electricity) â€“ cum â€“ Principal Chief Electrical Inspector\nState Designated Agency Odisha, Department of Energy\nGovernment of Odisha, Power House Square, Bidyut Marg,\nBhubaneswar â€“ 751 001, Odisha.",lineWidth:240}}]},1).to({state:[{t:this.instance,p:{regX:-0.1,regY:-0.1,scaleX:1.633,scaleY:0.9555,x:-87,y:-241.65}},{t:this.text,p:{scaleX:1.633,scaleY:1.633,x:-285.2659,y:-313.4393,text:"Distribution Wing, Power Development Department (PDD Distribution),\nAdministration of Union Territory of Ladakh,\nLadakh (Kargil).",lineWidth:240}}]},1).to({state:[{t:this.instance,p:{regX:-0.1,regY:-0.1,scaleX:1.4048,scaleY:1.0858,x:-40.55,y:-127.45}},{t:this.text,p:{scaleX:1.4501,scaleY:1.4501,x:-209.3502,y:-215.9102,text:"Senior Electrical Inspector\nInspectorate of Electricity, Government of Meghalaya,\nHorse Shoe Building, Lower Lachumiere,\nShillong â€“ 793 001, Meghalaya.",lineWidth:240}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:-0.1,scaleX:1.7101,scaleY:1.1985,x:-131.15,y:-60.55}},{t:this.text,p:{scaleX:1.7101,scaleY:1.7101,x:-338.9203,y:-157.7283,text:"Rajasthan Renewable Energy Corporation Ltd (RRECL)\nE-166, Yudhishthir Marg,\nC-Scheme,\nJaipur â€“ 302 005, Rajasthan.",lineWidth:240}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:-0.1,scaleX:1.3124,scaleY:1.1529,x:-62.45,y:-7.4}},{t:this.text,p:{scaleX:1.3124,scaleY:1.3124,x:-221.7248,y:-103.1624,text:"Additional Chief Engineer (IPP) cum Nodal Officer Sikkim SDA\nEnergy & Power Department, Government of Sikkim\nPower Secretariat, Kazi Road,\nGangtok â€“ 737 101, Sikkim.",lineWidth:240}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:0,scaleX:1.4593,scaleY:0.8959,x:-119.9,y:71.75}},{t:this.text,p:{scaleX:1.4593,scaleY:1.4593,x:-297.2186,y:2.3733,text:"Tamil Nadu Generation & Distribution Corporation Limited\n5th Floor, Eastern Wing,\n144, Anna Salai, Chennai- 600002",lineWidth:240}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:0,scaleX:1.4245,scaleY:1.3661,x:-78.55,y:25.35}},{t:this.text,p:{scaleX:1.4245,scaleY:1.4245,x:-251.6491,y:-87.8642,text:"Vice Chairman & Managing Director\nTelangana State Renewable Energy Development Corporation (TSREDCO) Ltd.\nD.No. 6-2-910, Visvesvaraya Bhavan,\nThe Institution of Engineers Building, Khairatabad,\nHyderabad â€“ 500 001, Telangana.",lineWidth:240}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:-0.1,scaleX:1.3126,scaleY:0.6485,x:-28.45,y:-16.8}},{t:this.text,p:{scaleX:1.3126,scaleY:1.3126,x:-187.9252,y:-65.9127,text:"Tripura State Electricity Corporation Limited\nBidyut Bhawan, North Banamalipur,\nAgartala, Tripura (West)-799001",lineWidth:240}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:0,scaleX:1.5172,scaleY:0.9363,x:-72.65,y:-216.8}},{t:this.text,p:{scaleX:1.5172,scaleY:1.5172,x:-256.9844,y:-288.7809,text:"Uttar Pradesh New and Renewable Energy Development Agency (UPNEDA)\nVibhuti Khand, Gomti Nagar,\nLucknow â€“ 226010, Uttar Pradesh.",lineWidth:240}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:0,scaleX:1.3088,scaleY:1.0143,x:-369.1,y:-279.6}},{t:this.text,p:{scaleX:1.3088,scaleY:1.3088,x:-528.0675,y:-359.5058,text:"Uttarakhand Renewable Energy Development Agency (UREDA)\nUrja Park Campus, Industrial Area, Patel Nagar,\nDehradun â€“ 248 001, Uttarakhand.",lineWidth:240}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:-0.2,scaleX:1.3782,scaleY:0.571,x:-71.45,y:-170.05}},{t:this.text,p:{scaleX:1.3782,scaleY:1.3782,x:-238.3565,y:-216.8308,text:"Vidyut Bhavan, 5th Floor, B-Black, Bidhannagar,\nBlock - DJ, Sector - II, Kolkata - 700091",lineWidth:240}}]},1).to({state:[{t:this.instance,p:{regX:-0.1,regY:0.1,scaleX:1.3434,scaleY:0.9471,x:-97.8,y:94.45}},{t:this.text,p:{scaleX:1.3434,scaleY:1.3434,x:-260.3868,y:20.4819,text:"Renewable Energy Agency Puducherry (REAP)\nBungalow No.2, AFT Premises, Cuddalore Main Road, \nMudaliarpet, Puducherry-605004.",lineWidth:240}}]},1).to({state:[{t:this.instance,p:{regX:0,regY:0,scaleX:1,scaleY:0.7163,x:-276.8,y:-58.45}},{t:this.text,p:{scaleX:1,scaleY:1,x:-397.9,y:-115.15,text:"Electricity Department,\n4th Floor, Vidyut Bhavan, Near 66/11 KV Kachigam Sub-Station,\nSomnath - Kachigam Road,\nKachigam â€“ 396 210, Daman.",lineWidth:240}}]},1).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-582.8,-367.6,730.1999999999999,520.8);


(lib.Symbol70Rajasthan = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_6
	this.text = new cjs.Text("Rajasthan", "bold 10px 'Arial'");
	this.text.lineHeight = 11;
	this.text.parent = this;
	this.text.setTransform(1.85,42);

	this.timeline.addTween(cjs.Tween.get(this.text).wait(1));

	// Layer_4
	this.instance = new lib.Symbol73Rajasthan();
	this.instance.setTransform(22.3,36.5,1,1,0,0,0,18.8,7.7);
	this.instance.alpha = 0;

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	// Layer_3
	this.instance_1 = new lib.Symbol72Rajasthan();
	this.instance_1.setTransform(27.65,29,1,1,0,0,0,11.3,11);

	this.timeline.addTween(cjs.Tween.get(this.instance_1).wait(1));

	// Layer_1
	this.instance_2 = new lib.Symbol71Rajasthan();
	this.instance_2.setTransform(50.2,0,1,1,0,0,0,50.2,0);

	this.timeline.addTween(cjs.Tween.get(this.instance_2).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol70Rajasthan, new cjs.Rectangle(-47.7,-29.9,141,128.9), null);


(lib.Symbol70Gujarat = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this.isSingleFrame = false;
	// timeline functions:
	this.frame_0 = function() {
		if(this.isSingleFrame) {
			return;
		}
		if(this.totalFrames == 1) {
			this.isSingleFrame = true;
		}
		this.stop()
	}

	// actions tween:
	this.timeline.addTween(cjs.Tween.get(this).call(this.frame_0).wait(1));

	// Layer_4
	this.text = new cjs.Text("Gujarat", "bold 12px 'Arial'");
	this.text.lineHeight = 14;
	this.text.parent = this;
	this.text.setTransform(-77.2,26.5);

	this.timeline.addTween(cjs.Tween.get(this.text).wait(1));

	// Layer_3
	this.instance = new lib.Symbol72Gujarat();
	this.instance.setTransform(27.65,29,1,1,0,0,0,11.3,11);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	// Layer_1
	this.instance_1 = new lib.Symbol71Gujarat();
	this.instance_1.setTransform(50.2,0,1,1,0,0,0,50.2,0);

	this.timeline.addTween(cjs.Tween.get(this.instance_1).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol70Gujarat, new cjs.Rectangle(-79.2,1.1,149.5,83.5), null);


(lib.Symbol70Telangana = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_6
	this.text = new cjs.Text("Telangana", "bold 10px 'Arial'");
	this.text.lineHeight = 11;
	this.text.parent = this;
	this.text.setTransform(-6.1,49.3);

	this.timeline.addTween(cjs.Tween.get(this.text).wait(1));

	// Layer_3
	this.instance = new lib.Symbol72Telangana();
	this.instance.setTransform(28,27.25,1,1,0,0,0,11.3,11);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	// Layer_1
	this.instance_1 = new lib.Symbol71Telangana();
	this.instance_1.setTransform(50.2,0,1,1,0,0,0,50.2,0);

	this.timeline.addTween(cjs.Tween.get(this.instance_1).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol70Telangana, new cjs.Rectangle(-11.7,7.8,75.2,70.2), null);


(lib.Symbol70TamilNadu = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this.isSingleFrame = false;
	// timeline functions:
	this.frame_0 = function() {
		if(this.isSingleFrame) {
			return;
		}
		if(this.totalFrames == 1) {
			this.isSingleFrame = true;
		}
		this.stop()
	}

	// actions tween:
	this.timeline.addTween(cjs.Tween.get(this).call(this.frame_0).wait(1));

	// Layer_4
	this.instance = new lib.Symbol73TamilNadu();
	this.instance.setTransform(22.3,36.5,1,1,0,0,0,18.8,7.7);
	this.instance.alpha = 0;

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	// Layer_3
	this.instance_1 = new lib.Symbol72TamilNadu();
	this.instance_1.setTransform(27.65,29,1,1,0,0,0,11.3,11);

	this.timeline.addTween(cjs.Tween.get(this.instance_1).wait(1));

	// Layer_1
	this.instance_2 = new lib.Symbol71TamilNadu();
	this.instance_2.setTransform(50.2,0,1,1,0,0,0,50.2,0);

	this.timeline.addTween(cjs.Tween.get(this.instance_2).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol70TamilNadu, new cjs.Rectangle(-53,-21.5,148,103.2), null);


(lib.Symbol70Orissa = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_3
	this.instance = new lib.Symbol72Orissa();
	this.instance.setTransform(25.35,23.4,1,1,0,0,0,11.3,11);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	// Layer_1
	this.instance_1 = new lib.Symbol71Orissa();
	this.instance_1.setTransform(50.2,0,1,1,0,0,0,50.2,0);

	this.timeline.addTween(cjs.Tween.get(this.instance_1).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol70Orissa, new cjs.Rectangle(-35.5,4.5,101.2,87.2), null);


(lib.Symbol70Maharashatra = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_4
	this.text = new cjs.Text("Maharashtra", "bold 10px 'Arial'");
	this.text.lineHeight = 11;
	this.text.parent = this;
	this.text.setTransform(-9.35,39.65);

	this.timeline.addTween(cjs.Tween.get(this.text).wait(1));

	// Layer_3
	this.instance = new lib.Symbol72Maharashatra();
	this.instance.setTransform(18.45,25.45,1,1,0,0,0,11.3,11);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	// Layer_1
	this.instance_1 = new lib.Symbol71Maharashatra();
	this.instance_1.setTransform(50.2,0,1,1,0,0,0,50.2,0);

	this.timeline.addTween(cjs.Tween.get(this.instance_1).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol70Maharashatra, new cjs.Rectangle(-20.2,-21.1,140.1,114.9), null);


(lib.Symbol70MadhyaPradesh = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this.isSingleFrame = false;
	// timeline functions:
	this.frame_0 = function() {
		if(this.isSingleFrame) {
			return;
		}
		if(this.totalFrames == 1) {
			this.isSingleFrame = true;
		}
		this.stop()
	}

	// actions tween:
	this.timeline.addTween(cjs.Tween.get(this).call(this.frame_0).wait(1));

	// Layer_6
	this.text = new cjs.Text("Madhya Pradesh", "bold 10px 'Arial'");
	this.text.lineHeight = 11;
	this.text.alpha = 0.87843137;
	this.text.parent = this;
	this.text.setTransform(-17,43.15);

	this.timeline.addTween(cjs.Tween.get(this.text).wait(1));

	// Layer_4
	this.instance = new lib.Symbol73MadhyaPradesh();
	this.instance.setTransform(22.3,36.5,1,1,0,0,0,18.8,7.7);
	this.instance.alpha = 0;

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	// Layer_3
	this.instance_1 = new lib.Symbol72MadhyaPradesh();
	this.instance_1.setTransform(16.8,26.65,1,1,0,0,0,11.3,11);

	this.timeline.addTween(cjs.Tween.get(this.instance_1).wait(1));

	// Layer_1
	this.instance_2 = new lib.Symbol71MadhyaPradesh();
	this.instance_2.setTransform(50.2,0,1,1,0,0,0,50.2,0);

	this.timeline.addTween(cjs.Tween.get(this.instance_2).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol70MadhyaPradesh, new cjs.Rectangle(-42.6,-32.6,150.9,101.9), null);


(lib.Symbol70Karnataka = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this.isSingleFrame = false;
	// timeline functions:
	this.frame_0 = function() {
		if(this.isSingleFrame) {
			return;
		}
		if(this.totalFrames == 1) {
			this.isSingleFrame = true;
		}
		this.stop()
	}

	// actions tween:
	this.timeline.addTween(cjs.Tween.get(this).call(this.frame_0).wait(1));

	// Layer_3
	this.instance = new lib.Symbol72Karnataka();
	this.instance.setTransform(27.65,29,1,1,0,0,0,11.3,11);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	// Layer_1
	this.instance_1 = new lib.Symbol71Karnataka();
	this.instance_1.setTransform(50.2,0,1,1,0,0,0,50.2,0);

	this.timeline.addTween(cjs.Tween.get(this.instance_1).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol70Karnataka, new cjs.Rectangle(2,-37.9,79.4,123), null);


(lib.Symbol70AndhraPradesh = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_3
	this.instance = new lib.Symbol72AndhraPradesh();
	this.instance.setTransform(27.65,29,1,1,0,0,0,11.3,11);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	// Layer_6
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#FE9898").ss(2,1,1).p("AJhAAIzBAA");
	this.shape.setTransform(81.7,50.75);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	// Layer_1
	this.instance_1 = new lib.Symbol71AndhraPradesh();
	this.instance_1.setTransform(50.2,0,1,1,0,0,0,50.2,0);

	this.timeline.addTween(cjs.Tween.get(this.instance_1).wait(1));

	// Layer_4
	this.text = new cjs.Text("Andhra Pradesh", "bold 12px 'Arial'");
	this.text.lineHeight = 14;
	this.text.parent = this;
	this.text.setTransform(60.25,33.65);

	this.instance_2 = new lib.Symbol73AndhraPradesh();
	this.instance_2.setTransform(22.3,36.5,1,1,0,0,0,18.8,7.7);
	this.instance_2.alpha = 0;

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_2},{t:this.text}]}).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol70AndhraPradesh, new cjs.Rectangle(-16.2,-31.3,171.29999999999998,117.39999999999999), null);


(lib.Symbol70Bihar = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_6
	this.text = new cjs.Text("Bihar", "bold 10px 'Arial'");
	this.text.lineHeight = 11;
	this.text.parent = this;
	this.text.setTransform(3.8,34.15);

	this.timeline.addTween(cjs.Tween.get(this.text).wait(1));

	// Layer_4
	this.instance = new lib.Symbol73Bihar();
	this.instance.setTransform(22.3,36.5,1,1,0,0,0,18.8,7.7);
	this.instance.alpha = 0;

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	// Layer_3
	this.instance_1 = new lib.Symbol72Bihar();
	this.instance_1.setTransform(24.65,25.3,1,1,0,0,0,11.3,11);

	this.timeline.addTween(cjs.Tween.get(this.instance_1).wait(1));

	// Layer_1
	this.instance_2 = new lib.Symbol71Bihar();
	this.instance_2.setTransform(50.2,0,1,1,0,0,0,50.2,0);

	this.timeline.addTween(cjs.Tween.get(this.instance_2).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.Symbol70Bihar, new cjs.Rectangle(-17.3,2.4,79.1,56.6), null);


(lib.sprite1161 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.instance = new lib.sprite1160();
	this.instance.setTransform(-66.45,-6.05);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.sprite1161, new cjs.Rectangle(0,0,0,0), null);


(lib.sprite1022 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.instance = new lib.sprite1021();
	this.instance.setTransform(-61.85,2);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.sprite1022, new cjs.Rectangle(0,0,0,0), null);


(lib.sprite926 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.instance = new lib.sprite925();
	this.instance.setTransform(-61.85,2);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.sprite926, new cjs.Rectangle(0,0,0,0), null);


(lib.sprite920 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.instance = new lib.shape919("synched",0);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.sprite920, new cjs.Rectangle(-1,-1,34.2,38.1), null);


(lib.sprite908 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.instance = new lib.sprite907();
	this.instance.setTransform(-61.85,2);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.sprite908, new cjs.Rectangle(0,0,0,0), null);


(lib.sprite901 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_6
	this.instance = new lib.shape843("synched",0);
	this.instance.setTransform(87.2,8.1,0.0108,0.0108);
	this.instance.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 0, 0, 255)];
	this.instance.cache(66,-735,94,737);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	// Layer_5
	this.instance_1 = new lib.shape617("synched",0);
	this.instance_1.setTransform(81.1,8.1,0.0108,0.0108);
	this.instance_1.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 0, 0, 255)];
	this.instance_1.cache(35,-545,493,559);

	this.timeline.addTween(cjs.Tween.get(this.instance_1).wait(1));

	// Layer_4
	this.instance_2 = new lib.shape900("synched",0);
	this.instance_2.setTransform(75,8.1,0.0108,0.0108);
	this.instance_2.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 0, 0, 255)];
	this.instance_2.cache(65,-735,465,749);

	this.timeline.addTween(cjs.Tween.get(this.instance_2).wait(1));

	// Layer_3
	this.instance_3 = new lib.shape844("synched",0);
	this.instance_3.setTransform(65.85,8.1,0.0108,0.0108);
	this.instance_3.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 0, 0, 255)];
	this.instance_3.cache(66,-545,724,547);

	this.timeline.addTween(cjs.Tween.get(this.instance_3).wait(1));

	// Layer_2
	this.instance_4 = new lib.shape899("synched",0);
	this.instance_4.setTransform(59.75,8.1,0.0108,0.0108);
	this.instance_4.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 0, 0, 255)];
	this.instance_4.cache(64,-533,435,547);

	this.timeline.addTween(cjs.Tween.get(this.instance_4).wait(1));

	// Layer_1
	this.instance_5 = new lib.shape852("synched",0);
	this.instance_5.setTransform(50.6,8.1,0.0108,0.0108);
	this.instance_5.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 0, 0, 255)];
	this.instance_5.cache(74,-735,704,737);

	this.timeline.addTween(cjs.Tween.get(this.instance_5).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.sprite901, new cjs.Rectangle(51.4,0.2,37.50000000000001,8.100000000000001), null);


(lib.sprite897 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_37
	this.instance = new lib.shape481("synched",0);
	this.instance.setTransform(481,11.4,0.0137,0.0137);
	this.instance.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance.cache(72,-142,145,145);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	// Layer_36
	this.instance_1 = new lib.shape893("synched",0);
	this.instance_1.setTransform(472.45,11.4,0.0137,0.0137);
	this.instance_1.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_1.cache(68,-545,522,749);

	this.timeline.addTween(cjs.Tween.get(this.instance_1).wait(1));

	// Layer_35
	this.instance_2 = new lib.shape891("synched",0);
	this.instance_2.setTransform(464.65,11.4,0.0137,0.0137);
	this.instance_2.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_2.cache(35,-545,503,559);

	this.timeline.addTween(cjs.Tween.get(this.instance_2).wait(1));

	// Layer_34
	this.instance_3 = new lib.shape892("synched",0);
	this.instance_3.setTransform(453,11.4,0.0137,0.0137);
	this.instance_3.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_3.cache(71,-735,712,737);

	this.timeline.addTween(cjs.Tween.get(this.instance_3).wait(1));

	// Layer_33
	this.instance_4 = new lib.shape891("synched",0);
	this.instance_4.setTransform(441.3,11.4,0.0137,0.0137);
	this.instance_4.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_4.cache(35,-545,503,559);

	this.timeline.addTween(cjs.Tween.get(this.instance_4).wait(1));

	// Layer_32
	this.instance_5 = new lib.shape882("synched",0);
	this.instance_5.setTransform(437.4,11.4,0.0137,0.0137);
	this.instance_5.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_5.cache(72,-735,145,737);

	this.timeline.addTween(cjs.Tween.get(this.instance_5).wait(1));

	// Layer_31
	this.instance_6 = new lib.shape896("synched",0);
	this.instance_6.setTransform(428.85,11.4,0.0137,0.0137);
	this.instance_6.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_6.cache(40,-735,523,749);

	this.timeline.addTween(cjs.Tween.get(this.instance_6).wait(1));

	// Layer_30
	this.instance_7 = new lib.shape886("synched",0);
	this.instance_7.setTransform(420.3,11.4,0.0137,0.0137);
	this.instance_7.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_7.cache(71,-545,488,547);

	this.timeline.addTween(cjs.Tween.get(this.instance_7).wait(1));

	// Layer_29
	this.instance_8 = new lib.shape481("synched",0);
	this.instance_8.setTransform(416.3,11.4,0.0145,0.0716);
	this.instance_8.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_8.cache(72,-142,145,145);

	this.timeline.addTween(cjs.Tween.get(this.instance_8).wait(1));

	// Layer_28
	this.instance_9 = new lib.shape885("synched",0);
	this.instance_9.setTransform(403.95,11.4,0.0137,0.0137);
	this.instance_9.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_9.cache(39,-545,552,559);

	this.timeline.addTween(cjs.Tween.get(this.instance_9).wait(1));

	// Layer_27
	this.instance_10 = new lib.shape887("synched",0);
	this.instance_10.setTransform(399.3,11.4,0.0137,0.0137);
	this.instance_10.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_10.cache(14,-720,317,735);

	this.timeline.addTween(cjs.Tween.get(this.instance_10).wait(1));

	// Layer_26
	this.instance_11 = new lib.shape884("synched",0);
	this.instance_11.setTransform(387.6,11.4,0.0137,0.0137);
	this.instance_11.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_11.cache(67,-735,495,737);

	this.timeline.addTween(cjs.Tween.get(this.instance_11).wait(1));

	// Layer_25
	this.instance_12 = new lib.shape883("synched",0);
	this.instance_12.setTransform(379.8,11.4,0.0137,0.0137);
	this.instance_12.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_12.cache(41,-545,505,559);

	this.timeline.addTween(cjs.Tween.get(this.instance_12).wait(1));

	// Layer_24
	this.instance_13 = new lib.shape891("synched",0);
	this.instance_13.setTransform(372,11.4,0.0137,0.0137);
	this.instance_13.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_13.cache(35,-545,503,559);

	this.timeline.addTween(cjs.Tween.get(this.instance_13).wait(1));

	// Layer_23
	this.instance_14 = new lib.shape895("synched",0);
	this.instance_14.setTransform(363.45,11.4,0.0137,0.0137);
	this.instance_14.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_14.cache(66,-735,523,749);

	this.timeline.addTween(cjs.Tween.get(this.instance_14).wait(1));

	// Layer_22
	this.instance_15 = new lib.shape885("synched",0);
	this.instance_15.setTransform(351,11.4,0.0137,0.0137);
	this.instance_15.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_15.cache(39,-545,552,559);

	this.timeline.addTween(cjs.Tween.get(this.instance_15).wait(1));

	// Layer_21
	this.instance_16 = new lib.shape894("synched",0);
	this.instance_16.setTransform(342.45,11.4,0.0137,0.0137);
	this.instance_16.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_16.cache(40,-545,522,763);

	this.timeline.addTween(cjs.Tween.get(this.instance_16).wait(1));

	// Layer_20
	this.instance_17 = new lib.shape885("synched",0);
	this.instance_17.setTransform(330,11.4,0.0137,0.0137);
	this.instance_17.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_17.cache(39,-545,552,559);

	this.timeline.addTween(cjs.Tween.get(this.instance_17).wait(1));

	// Layer_19
	this.instance_18 = new lib.shape887("synched",0);
	this.instance_18.setTransform(325.35,11.4,0.0137,0.0137);
	this.instance_18.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_18.cache(14,-720,317,735);

	this.timeline.addTween(cjs.Tween.get(this.instance_18).wait(1));

	// Layer_18
	this.instance_19 = new lib.shape893("synched",0);
	this.instance_19.setTransform(312.9,11.4,0.0137,0.0137);
	this.instance_19.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_19.cache(68,-545,522,749);

	this.timeline.addTween(cjs.Tween.get(this.instance_19).wait(1));

	// Layer_17
	this.instance_20 = new lib.shape891("synched",0);
	this.instance_20.setTransform(305.1,11.4,0.0137,0.0137);
	this.instance_20.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_20.cache(35,-545,503,559);

	this.timeline.addTween(cjs.Tween.get(this.instance_20).wait(1));

	// Layer_16
	this.instance_21 = new lib.shape892("synched",0);
	this.instance_21.setTransform(293.45,11.4,0.0137,0.0137);
	this.instance_21.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_21.cache(71,-735,712,737);

	this.timeline.addTween(cjs.Tween.get(this.instance_21).wait(1));

	// Layer_15
	this.instance_22 = new lib.shape889("synched",0);
	this.instance_22.setTransform(281.75,11.4,0.0137,0.0137);
	this.instance_22.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_22.cache(31,-545,500,559);

	this.timeline.addTween(cjs.Tween.get(this.instance_22).wait(1));

	// Layer_14
	this.instance_23 = new lib.shape887("synched",0);
	this.instance_23.setTransform(277.1,11.4,0.0137,0.0137);
	this.instance_23.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_23.cache(14,-720,317,735);

	this.timeline.addTween(cjs.Tween.get(this.instance_23).wait(1));

	// Layer_13
	this.instance_24 = new lib.shape891("synched",0);
	this.instance_24.setTransform(269.3,11.4,0.0137,0.0137);
	this.instance_24.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_24.cache(35,-545,503,559);

	this.timeline.addTween(cjs.Tween.get(this.instance_24).wait(1));

	// Layer_12
	this.instance_25 = new lib.shape887("synched",0);
	this.instance_25.setTransform(264.65,11.4,0.0137,0.0137);
	this.instance_25.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_25.cache(14,-720,317,735);

	this.timeline.addTween(cjs.Tween.get(this.instance_25).wait(1));

	// Layer_11
	this.instance_26 = new lib.shape890("synched",0);
	this.instance_26.setTransform(255.3,11.4,0.0137,0.0137);
	this.instance_26.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_26.cache(35,-747,600,763);

	this.timeline.addTween(cjs.Tween.get(this.instance_26).wait(1));

	// Layer_10
	this.instance_27 = new lib.shape889("synched",0);
	this.instance_27.setTransform(243.6,11.4,0.0137,0.0137);
	this.instance_27.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_27.cache(31,-545,500,559);

	this.timeline.addTween(cjs.Tween.get(this.instance_27).wait(1));

	// Layer_9
	this.instance_28 = new lib.shape888("synched",0);
	this.instance_28.setTransform(235.05,11.4,0.0137,0.0137);
	this.instance_28.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_28.cache(71,-735,488,737);

	this.timeline.addTween(cjs.Tween.get(this.instance_28).wait(1));

	// Layer_8
	this.instance_29 = new lib.shape887("synched",0);
	this.instance_29.setTransform(230.4,11.4,0.0137,0.0137);
	this.instance_29.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_29.cache(14,-720,317,735);

	this.timeline.addTween(cjs.Tween.get(this.instance_29).wait(1));

	// Layer_7
	this.instance_30 = new lib.shape886("synched",0);
	this.instance_30.setTransform(217.95,11.4,0.0137,0.0137);
	this.instance_30.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_30.cache(71,-545,488,547);

	this.timeline.addTween(cjs.Tween.get(this.instance_30).wait(1));

	// Layer_6
	this.instance_31 = new lib.shape885("synched",0);
	this.instance_31.setTransform(209.4,11.4,0.0137,0.0137);
	this.instance_31.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_31.cache(39,-545,552,559);

	this.timeline.addTween(cjs.Tween.get(this.instance_31).wait(1));

	// Layer_5
	this.instance_32 = new lib.shape884("synched",0);
	this.instance_32.setTransform(197.7,11.4,0.0137,0.0137);
	this.instance_32.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_32.cache(67,-735,495,737);

	this.timeline.addTween(cjs.Tween.get(this.instance_32).wait(1));

	// Layer_4
	this.instance_33 = new lib.shape883("synched",0);
	this.instance_33.setTransform(189.9,11.4,0.0137,0.0137);
	this.instance_33.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_33.cache(41,-545,505,559);

	this.timeline.addTween(cjs.Tween.get(this.instance_33).wait(1));

	// Layer_3
	this.instance_34 = new lib.shape882("synched",0);
	this.instance_34.setTransform(186,11.4,0.0137,0.0137);
	this.instance_34.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_34.cache(72,-735,145,737);

	this.timeline.addTween(cjs.Tween.get(this.instance_34).wait(1));

	// Layer_2
	this.instance_35 = new lib.shape481("synched",0);
	this.instance_35.setTransform(182.1,11.4,0.0137,0.0716);
	this.instance_35.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_35.cache(72,-142,145,145);

	this.timeline.addTween(cjs.Tween.get(this.instance_35).wait(1));

	// Layer_1
	this.instance_36 = new lib.shape881("synched",0);
	this.instance_36.setTransform(172,11.4,0.0137,0.0137);
	this.instance_36.filters = [new cjs.ColorFilter(1, 1, 1, 1, 0, 102, 0, 255)];
	this.instance_36.cache(47,-747,643,762);

	this.timeline.addTween(cjs.Tween.get(this.instance_36).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.sprite897, new cjs.Rectangle(172.7,1.2,311.3,13.200000000000001), null);


(lib.sprite865 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.instance = new lib.sprite864();
	this.instance.setTransform(-66.45,-6.05);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.sprite865, new cjs.Rectangle(0,0,0,0), null);


(lib.sprite835 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.instance = new lib.sprite834();
	this.instance.setTransform(-61.85,2);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.sprite835, new cjs.Rectangle(0,0,0,0), null);


(lib.sprite757 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.instance = new lib.sprite756();
	this.instance.setTransform(-61.85,2);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.sprite757, new cjs.Rectangle(0,0,0,0), null);


(lib.sprite699 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.instance = new lib.sprite698();
	this.instance.setTransform(-66.45,-6.05);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.sprite699, new cjs.Rectangle(0,0,0,0), null);


(lib.sprite643 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.instance = new lib.text642("synched",0);
	this.instance.setTransform(20.65,25.35);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.sprite643, new cjs.Rectangle(0,0,0,0), null);


(lib.sprite92 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_1
	this.instance = new lib.shape82("synched",0);
	this.instance.setTransform(-45.9,0,1.1037,21.8916);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.sprite92, new cjs.Rectangle(-178,0,993.4,676.5), null);


(lib.shape1156UpOverDownHit = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_2
	this.instance = new lib.Symbol52();
	this.instance.setTransform(49.2,22.4,1,1,0,0,0,58.7,0);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-9.5,22.4,117.5,87.30000000000001);


(lib.button687 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.shape686UpOverDownHit("synched",0);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1).to({startPosition:0},0).wait(1).to({startPosition:0},0).wait(1).to({startPosition:0},0).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(62.7,27.8,3.3999999999999915,5.4999999999999964);


(lib.Symbol114 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.Symbol70Gujarat();
	this.instance.setTransform(104.3,23.75,1,1,0,0,0,25.1,24.8);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,149.5,83.6);


(lib.Symbol113 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.Symbol70Rajasthan();
	this.instance.setTransform(72.8,54.7,1,1,0,0,0,25.1,24.8);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,141,128.9);


(lib.Symbol112 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.Symbol70MadhyaPradesh();
	this.instance.setTransform(67.75,57.45,1,1,0,0,0,25.1,24.8);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,151,101.9);


(lib.Symbol102 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.Symbol70Bihar();
	this.instance.setTransform(42.4,22.4,1,1,0,0,0,25.1,24.8);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,79.1,56.6);


(lib.Symbol101 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.Symbol70Telangana();
	this.instance.setTransform(36.8,17.05,1,1,0,0,0,25.1,24.8);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,75.2,70.3);


(lib.Symbol100 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.Symbol70AndhraPradesh();
	this.instance.setTransform(41.35,56.1,1,1,0,0,0,25.1,24.8);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,171.4,117.4);


(lib.Symbol99 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.sprite545();
	this.instance.setTransform(131.65,40.2,0.6,0.6);

	this.instance_1 = new lib.sprite87();
	this.instance_1.setTransform(116.7,45.3,0.6,0.6);

	this.text = new cjs.Text("Tamil Nadu", "bold 12px 'Arial'");
	this.text.lineHeight = 14;
	this.text.lineWidth = 72;
	this.text.parent = this;
	this.text.setTransform(140.7,29.1);

	this.pudo_btn = new lib.button687();
	this.pudo_btn.name = "pudo_btn";
	this.pudo_btn.setTransform(90.7,2.5);
	new cjs.ButtonHelper(this.pudo_btn, 0, 1, 2, false, new lib.button687(), 3);

	this.instance_2 = new lib.Symbol70TamilNadu();
	this.instance_2.setTransform(78.15,46.3,1,1,0,0,0,25.1,24.8);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#C2CEE3").ss(2,1,1).p("AJsAAIzXAA");
	this.shape.setTransform(161.875,44.8);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape},{t:this.instance_2},{t:this.pudo_btn},{t:this.text},{t:this.instance_1},{t:this.instance}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,224.9,103.2);


(lib.Symbol98 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.Symbol70Maharashatra();
	this.instance.setTransform(45.35,45.95,1,1,0,0,0,25.1,24.8);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,140.1,115);


(lib.Symbol96 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.text = new cjs.Text("Orissa", "bold 10px 'Arial'");
	this.text.lineHeight = 11;
	this.text.parent = this;
	this.text.setTransform(36.7,41.2);

	this.instance = new lib.Symbol70Orissa();
	this.instance.setTransform(60.65,20.35,1,1,0,0,0,25.1,24.8);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance},{t:this.text}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,101.2,87.3);


(lib.Symbol88 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.text = new cjs.Text("Jammu & Kashmir", "bold 12px 'Arial'");
	this.text.textAlign = "center";
	this.text.lineHeight = 14;
	this.text.alpha = 0.87843137;
	this.text.parent = this;
	this.text.setTransform(51.3,51.35);

	this.instance = new lib.PDDlogo();
	this.instance.setTransform(133.65,53.35,0.0831,0.0831);

	this.instance_1 = new lib.shape1156UpOverDownHit("synched",0);
	this.instance_1.setTransform(123.6,-22.4);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#FFCCFF").ss(2,1,1).p("ALaAAI2zAA");
	this.shape.setTransform(73.85,67);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("rgba(0,0,0,0.878)").s().p("AgQAaIAAgyIANAAIAAAHIAFgHIAGgCQAFAAAEADIgEAMQgEgCgDAAQgDAAgCACQgBABgBAEIgBARIAAAPg");
	this.shape_1.setTransform(87.625,57.95);

	this.shape_2 = new cjs.Shape();
	this.shape_2.graphics.f("rgba(0,0,0,0.878)").s().p("AgGAkIAAgzIANAAIAAAzgAgGgWIAAgNIANAAIAAANg");
	this.shape_2.setTransform(83.9,57.025);

	this.shape_3 = new cjs.Shape();
	this.shape_3.graphics.f("rgba(0,0,0,0.878)").s().p("AAYAaIAAgcQAAgIgBgCQgCgDgEAAQgDAAgCACQgDACgBADQgBADAAAHIAAAYIgNAAIAAgbIAAgKIgDgDIgEgBQgDAAgDACQgCACgBACIgBALIAAAYIgOAAIAAgyIANAAIAAAGQAGgHAKgBQAFABADACQADACACADQAEgDAEgCQAEgCAEgBQAGAAAEADQAEACACAEQABAEAAAIIAAAfg");
	this.shape_3.setTransform(78.025,57.95);

	this.shape_4 = new cjs.Shape();
	this.shape_4.graphics.f("rgba(0,0,0,0.878)").s().p("AAKAkIAAgcIgBgJQAAAAAAgBQgBAAAAgBQAAAAgBgBQAAAAgBAAQgCgCgDAAQgCAAgDACIgEAEIgBAKIAAAaIgOAAIAAhHIAOAAIAAAaQAHgHAIAAQAFAAAEABIAFAFQACADABADIABAJIAAAfg");
	this.shape_4.setTransform(70.575,57.025);

	this.shape_5 = new cjs.Shape();
	this.shape_5.graphics.f("rgba(0,0,0,0.878)").s().p("AgPAXQgHgEgBgIIANgCQABAEADACQADACADABQAGAAACgCQABgBAAAAQAAgBABAAQAAgBAAAAQAAgBAAgBIgBgCIgEgBQgQgFgEgDQgHgCAAgIQAAgHAGgFQAFgEALAAQAKAAAFADQAFAEACAGIgNADQAAgDgDgCQgCgBgEAAQgFAAgCABQgBABAAAAQAAAAAAABQgBAAAAAAQAAABAAAAQAAAAAAABQAAAAABAAQAAABAAAAQAAAAABABQABABAKACQALADAFADQAEADAAAHQAAAHgGAFQgGAFgMAAQgJAAgGgEg");
	this.shape_5.setTransform(64.625,58);

	this.shape_6 = new cjs.Shape();
	this.shape_6.graphics.f("rgba(0,0,0,0.878)").s().p("AgTAXQgEgEAAgHQAAgFACgDQACgEAEAAIALgEIAMgDIAAgBQAAgEgCgCQgCgBgEgBQgEABgCABQgCACgBADIgNgCQACgIAFgEQAGgDAJAAQAJAAAEACQAFADACADQACADAAAJIgBAPIABAKIACAHIgNAAIgBgEIgBgCQgDAEgEACQgDABgFAAQgIAAgFgEgAAAADIgHADQgCACAAACQAAAEACACQACACADAAQADgBADgCIAEgFIAAgGIAAgDIgIACg");
	this.shape_6.setTransform(59.175,58);

	this.shape_7 = new cjs.Shape();
	this.shape_7.graphics.f("rgba(0,0,0,0.878)").s().p("AAOAkIgTgiIgMAMIAAAWIgOAAIAAhHIAOAAIAAAgIAcggIAUAAIgbAcIAcArg");
	this.shape_7.setTransform(53.175,57.025);

	this.shape_8 = new cjs.Shape();
	this.shape_8.graphics.f("rgba(0,0,0,0.878)").s().p("AANAdQgFAEgEACQgEACgHAAQgNAAgHgHQgFgHAAgHQAAgHAEgFQAEgFAJgEIgHgIIgBgIQAAgGAFgFQAGgEAJgBQAIAAAGAGQAEAEAAAHQAAAFgCADQgDAEgHAFIAJAMQACgDABgFIANADIgDAKIgDAEIAGAFIAFAEIgIALQgGgDgGgGgAgPAIQgDAEAAADQAAAFADADQADACAFAAQADABADgCIAFgEIgMgRQgGACgBADgAgIgZQAAAAgBABQAAAAAAABQAAAAAAABQAAAAAAABQAAADADADIADAEIADgDQADgDAAgEQAAAAAAgBQAAAAAAgBQAAAAgBgBQAAgBAAAAQgCgCgDAAQgDAAgCACg");
	this.shape_8.setTransform(42.95,57.05);

	this.shape_9 = new cjs.Shape();
	this.shape_9.graphics.f("rgba(0,0,0,0.878)").s().p("AgPAYQgEgCgCgEQgCgEAAgIIAAgfIAOAAIAAAXQAAALABACQAAABAAAAQABABAAAAQAAABABAAQAAABAAAAIAGABQACAAADgCQADgBABgDQABgEAAgKIAAgVIAOAAIAAAyIgNAAIAAgIQgDAFgFACQgDACgGAAQgFAAgEgCg");
	this.shape_9.setTransform(33.35,58.05);

	this.shape_10 = new cjs.Shape();
	this.shape_10.graphics.f("rgba(0,0,0,0.878)").s().p("AAYAaIAAgcQAAgIgBgCQgCgDgEAAQgDAAgCACQgDACgBADQgBADAAAHIAAAYIgNAAIAAgbIAAgKIgDgDIgEgBQgDAAgDACQgCACgBACIgBALIAAAYIgOAAIAAgyIANAAIAAAGQAGgHAKgBQAFABADACQADACACADQAEgDAEgCQAEgCAEgBQAGAAAEADQAEACACAEQABAEAAAIIAAAfg");
	this.shape_10.setTransform(25.825,57.95);

	this.shape_11 = new cjs.Shape();
	this.shape_11.graphics.f("rgba(0,0,0,0.878)").s().p("AAYAaIAAgcQAAgIgBgCQgCgDgEAAQgDAAgCACQgDACgBADQgBADAAAHIAAAYIgNAAIAAgbIAAgKIgDgDIgEgBQgDAAgDACQgCACgBACIgBALIAAAYIgOAAIAAgyIANAAIAAAGQAGgHAKgBQAFABADACQADACACADQAEgDAEgCQAEgCAEgBQAGAAAEADQAEACACAEQABAEAAAIIAAAfg");
	this.shape_11.setTransform(16.925,57.95);

	this.shape_12 = new cjs.Shape();
	this.shape_12.graphics.f("rgba(0,0,0,0.878)").s().p("AgTAXQgEgEAAgHQAAgFACgDQACgEAEAAIALgEIAMgDIAAgBQAAgEgCgCQgCgBgEgBQgEABgCABQgCACgBADIgNgCQACgIAFgEQAGgDAJAAQAJAAAEACQAFADACADQACADAAAJIgBAPIABAKIACAHIgNAAIgBgEIgBgCQgDAEgEACQgDABgFAAQgIAAgFgEgAAAADIgHADQgCACAAACQAAAEACACQACACADAAQADgBADgCIAEgFIAAgGIAAgDIgIACg");
	this.shape_12.setTransform(9.725,58);

	this.shape_13 = new cjs.Shape();
	this.shape_13.graphics.f("rgba(0,0,0,0.878)").s().p("AgQAfQgGgGAAgMIAOgBQAAAGABACQADAEAEAAQAEAAACgDQACgCAAgJIAAgtIAPAAIAAAsQAAAJgBAFQgCAGgGAEQgFADgJAAQgLAAgFgFg");
	this.shape_13.setTransform(3.85,57.075);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape},{t:this.instance_1},{t:this.instance},{t:this.text}]}).to({state:[{t:this.shape},{t:this.instance_1},{t:this.instance},{t:this.shape_13},{t:this.shape_12},{t:this.shape_11},{t:this.shape_10},{t:this.shape_9},{t:this.shape_8},{t:this.shape_7},{t:this.shape_6},{t:this.shape_5},{t:this.shape_4},{t:this.shape_3},{t:this.shape_2},{t:this.shape_1}]},4).wait(1));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-3.4,-1,236,89.3);


(lib.Symbol86 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.text = new cjs.Text("Karnataka", "bold 11px 'Arial'");
	this.text.lineHeight = 13;
	this.text.parent = this;
	this.text.setTransform(0.9,71.8);

	this.instance = new lib.Symbol70Karnataka();
	this.instance.setTransform(108.85,62.75,1,1,0,0,0,25.1,24.8);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#FECB00").ss(2,1,1).p("AHzAAIvkAA");
	this.shape.setTransform(51.95,90.6);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape},{t:this.instance},{t:this.text}]}).wait(4));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-1.1,0,166.2,123.1);


(lib.sprite898 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer_2
	this.instance = new lib.sprite897();
	this.instance.setTransform(0.3,6.8);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	// Layer_1
	this.instance_1 = new lib.shape82("synched",0);

	this.timeline.addTween(cjs.Tween.get(this.instance_1).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.sprite898, new cjs.Rectangle(-119.7,0,900,30.9), null);


(lib.sprite902 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// timeline functions:
	this.frame_0 = function() {
		/* stop ();
		_parent.btn_enabled();
		*/
	}
	this.frame_4 = function() {
		/* stop ();
		fader_btn.enabled = false;
		_parent.maharashtra_btn.enabled = false;
		_parent.jammu_btn.enabled = false;
		*/
	}
	this.frame_6 = function() {
		/* gotoAndStop(1);
		this.swapDepths(_parent.top_mc);
		*/
	}

	// actions tween:
	this.timeline.addTween(cjs.Tween.get(this).call(this.frame_0).wait(4).call(this.frame_4).wait(2).call(this.frame_6).wait(1));

	// Layer_4
	this.instance = new lib.sprite898();
	this.instance.setTransform(-436.8,389.75);

	this.instance_1 = new lib.sprite901();
	this.instance_1.setTransform(-17.2,22.6);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[]}).to({state:[{t:this.instance}]},1).to({state:[{t:this.instance_1}]},4).wait(2));

	// Layer_2
	this.instance_2 = new lib.sprite87();
	this.instance_2.setTransform(54.8,44,0.6,0.6);

	this.fader_btn = new lib.sprite92();
	this.fader_btn.name = "fader_btn";
	this.fader_btn.setTransform(-154.8,-373.25);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_2}]}).to({state:[{t:this.fader_btn}]},1).to({state:[{t:this.instance_2}]},4).wait(2));

	// Layer_1
	this.instance_3 = new lib.shape880("synched",0);

	this.timeline.addTween(cjs.Tween.get(this.instance_3).wait(7));

	this._renderFirstFrame();

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-556.5,-373.2,1217.1,793.9);


(lib.sprite1180 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this.isSingleFrame = false;
	// timeline functions:
	this.frame_0 = function() {
		if(this.isSingleFrame) {
			return;
		}
		if(this.totalFrames == 1) {
			this.isSingleFrame = true;
		}
		this.stop()
		
		var that;
		var arr = ["j_k", "chandigarh", "punjab", "himachal", "uttarakhand", "haryana", "delhi", "rajsthan", "utterPradesh", "bihar", "meghalaya", "sikkim", "arunachalPradesh", "assam", "nagaland", "manipur", "mizoram", "tripura", "westBangal", "chattisgarh", "andhraPradesh", "orissa", "telangana", "tamilNadu", "kerela", "lakshadweep", "karnataka", "goa", "maharashtra", "dadra", "daman", "diu", "madhyaPradesh", "gujrat", "jharkhand", "puducherry", "ladakh", "andman"];
		var URLs = [
			"http://www.jkpdd.gov.in",
			"http://chandigarh.gov.in/dept_engg.htm",
			"http://peda.gov.in/",
			"http://admis.hp.nic.in/doe/DOEAuth/welcome.aspx",
			"http://ureda.uk.gov.in/",
			"http://www.hareda.gov.in/",
			"http://delhi.gov.in/wps/wcm/connect/doit_eerem/EEREM/Home/",
			"http://www.rrecl.com/",
			"http://www.upsavesenergy.com/",
			"http://www.breda.bih.nic.in/",
			"http://www.msda.nic.in/",
			"http://power.sikkim.gov.in/",
			"http://www.apeda.nic.in/",
			"http://www.asdagov.in/",
			"http://www.nsda.co.in/",
			"https://www.mspdcl.com/irj/go/km/docs/internet/MANIPUR/webpage/pages/Home.html",
			"http://www.sdamizoram.com/",
			"http://www.tsecl.in/",
			"http://www.wbsedcl.in/",
			"http://creda.co.in/",
			"http://www.apsecm.ap.gov.in/",
			"http://eicelectricityodisha.nic.in/",
			"https://tsredco.telangana.gov.in/",
			"http://www.tnei.tn.gov.in/",
			"http://www.keralaenergy.gov.in/",
			"https://lakshadweep.gov.in/departments/electricity/",
			"http://kredlinfo.in/Index_eng.aspx",
			"https://www.goaelectricity.gov.in/",
			"http://www.mahaurja.com/",
			"https://www.dnhpdcl.in/",
			"https://dded.gov.in/",
			"https://dded.gov.in/",
			"http://www.mprenewable.nic.in/",
			"http://geda.gujarat.gov.in/",
			"https://www.jreda.com",
			"https://reap.py.gov.in/",
			"https://ladakh.nic.in/",
			"http://electricity.and.nic.in/"
		]
		main(this);
		function main(_that) {
			that = _that;
			for (var i = 0; i < arr.length; i++) {
				var states = arr[i] + "_Btn";
				var state = that[states];
				//debugger
				if (state) {
					state.buttonMode = true;
					state.useHandCursor = true;
					state.addEventListener("click", onNextClick);
					state.addEventListener("mouseover", onmouseOverClick);
					state.addEventListener("mouseout", onmouseOutClick);
					state.ind = i;
				}
			}
		}
		
		
		
		function onmouseOverClick(e) {
		
			var str = e.currentTarget.name;
			var currentState = str.substring(0, str.length - 4);
			that.parent.movie11.gotoAndStop(currentState);
			var myVar = setInterval(myscale, 10);
			var x = .50
			var y = .50;
			function myscale() {
				if (x >= 1) {
					myStopFunction()
				} else {
					x += .05
					y += .05
					that.parent.movie11.scaleX = x;
					that.parent.movie11.scaleY = y;
					that.parent.movie11.alpha = x;
					console.log(x, y)
				}
			}
		
			function myStopFunction() {
				clearInterval(myVar);
			}
		}
		
		
		
		function onmouseOutClick(e) {
			that.parent.movie11.gotoAndStop(0);
		}
		
		function onNextClick(e) {
			var btn = e.currentTarget;
			var url = URLs[btn.ind];
			window.open(url, '_blank');
		}
		
		function onbackClick() {
			that._maps.gotoAndStop(0)
		}
		
		function onUrlClick(e) {
			var str = e.currentTarget.name;
			var urls = str.substring(4, str.length);
			var url = preURL + URLs[urls];
			console.log(url);
			window.open(url, '_blank');
		}
	}

	// actions tween:
	this.timeline.addTween(cjs.Tween.get(this).call(this.frame_0).wait(1));

	// Layer_19
	this.ladakh_Btn = new lib.laddakh();
	this.ladakh_Btn.name = "ladakh_Btn";
	this.ladakh_Btn.setTransform(-70.1,-298.55,1,1,0,0,0,59.5,44.5);
	new cjs.ButtonHelper(this.ladakh_Btn, 0, 1, 1);

	this.timeline.addTween(cjs.Tween.get(this.ladakh_Btn).wait(1));

	// Layer_17
	this.diu_Btn = new lib.Symbol124();
	this.diu_Btn.name = "diu_Btn";
	this.diu_Btn.setTransform(-212.05,-59.75,1,1,0,0,0,37.4,10.1);
	new cjs.ButtonHelper(this.diu_Btn, 0, 1, 2, false, new lib.Symbol124(), 3);

	this.daman_Btn = new lib.Symbol123();
	this.daman_Btn.name = "daman_Btn";
	this.daman_Btn.setTransform(-199.05,-53.5,1,1,0,0,0,61.3,10.1);
	new cjs.ButtonHelper(this.daman_Btn, 0, 1, 2, false, new lib.Symbol123(), 3);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.daman_Btn},{t:this.diu_Btn}]}).wait(1));

	// Layer_16
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#00FF00").ss(2,1,1).p("AAAlzIAALn");
	this.shape.setTransform(173.25,-184.9);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(1));

	// Layer_15
	this.puducherry_Btn = new lib.Symbol122();
	this.puducherry_Btn.name = "puducherry_Btn";
	this.puducherry_Btn.setTransform(20.4,145.55,1,1,0,0,0,77.3,11.3);
	new cjs.ButtonHelper(this.puducherry_Btn, 0, 1, 2, false, new lib.Symbol122(), 3);

	this.timeline.addTween(cjs.Tween.get(this.puducherry_Btn).wait(1));

	// Layer_14
	this.chandigarh_Btn = new lib.Symbol121();
	this.chandigarh_Btn.name = "chandigarh_Btn";
	this.chandigarh_Btn.setTransform(-135.8,-256.8,1,1,0,0,0,56.8,8.4);
	new cjs.ButtonHelper(this.chandigarh_Btn, 0, 1, 1);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f().s("#99FF00").ss(2,1,1).p("AHzAAIvlAA");
	this.shape_1.setTransform(12.95,-237.6);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_1},{t:this.chandigarh_Btn}]}).wait(1));

	// Layer_12
	this.shape_2 = new cjs.Shape();
	this.shape_2.graphics.f().s("#D6AE52").ss(2,1,1).p("ALyAAI3jAA");
	this.shape_2.setTransform(93.575,-15.6);

	this.timeline.addTween(cjs.Tween.get(this.shape_2).wait(1));

	// Layer_11
	this.bihar_Btn = new lib.Symbol102();
	this.bihar_Btn.name = "bihar_Btn";
	this.bihar_Btn.setTransform(75.9,-141.75,1,1,0,0,0,39.6,27.1);
	new cjs.ButtonHelper(this.bihar_Btn, 0, 1, 2, false, new lib.Symbol102(), 3);

	this.timeline.addTween(cjs.Tween.get(this.bihar_Btn).wait(1));

	// Layer_7394
	this.orissa_Btn = new lib.Symbol96();
	this.orissa_Btn.name = "orissa_Btn";
	this.orissa_Btn.setTransform(56.3,-40.55,1,1,0,0,0,50.6,41.4);
	new cjs.ButtonHelper(this.orissa_Btn, 0, 1, 2, false, new lib.Symbol96(), 3);

	this.westBangal_Btn = new lib.Symbol94();
	this.westBangal_Btn.name = "westBangal_Btn";
	this.westBangal_Btn.setTransform(163.55,-103.15,1,1,0,0,0,84.4,63.8);
	new cjs.ButtonHelper(this.westBangal_Btn, 0, 1, 2, false, new lib.Symbol94(), 3);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.westBangal_Btn},{t:this.orissa_Btn}]}).wait(1));

	// Layer_10
	this.andhraPradesh_Btn = new lib.Symbol100();
	this.andhraPradesh_Btn.name = "andhraPradesh_Btn";
	this.andhraPradesh_Btn.setTransform(7.4,40.9,1,1,0,0,0,81.4,58.6);
	new cjs.ButtonHelper(this.andhraPradesh_Btn, 0, 1, 2, false, new lib.Symbol100(), 3);

	this.timeline.addTween(cjs.Tween.get(this.andhraPradesh_Btn).wait(1));

	// Layer_4
	this.dadra_Btn = new lib.Symbol115();
	this.dadra_Btn.name = "dadra_Btn";
	this.dadra_Btn.setTransform(-214.75,-36.5,1,1,0,0,0,84.2,10.3);
	new cjs.ButtonHelper(this.dadra_Btn, 0, 1, 2, false, new lib.Symbol115(), 3);

	this.timeline.addTween(cjs.Tween.get(this.dadra_Btn).wait(1));

	// Layer_3681
	this.telangana_Btn = new lib.Symbol101();
	this.telangana_Btn.name = "telangana_Btn";
	this.telangana_Btn.setTransform(-27.25,-0.35,1,1,0,0,0,37.6,31.3);
	new cjs.ButtonHelper(this.telangana_Btn, 0, 1, 2, false, new lib.Symbol101(), 3);

	this.timeline.addTween(cjs.Tween.get(this.telangana_Btn).wait(1));

	// Layer_8
	this.karnataka_Btn = new lib.Symbol86();
	this.karnataka_Btn.name = "karnataka_Btn";
	this.karnataka_Btn.setTransform(-124.9,56.75,1,1,0,0,0,82.5,61.5);
	new cjs.ButtonHelper(this.karnataka_Btn, 0, 1, 2, false, new lib.Symbol86(), 3);

	this.timeline.addTween(cjs.Tween.get(this.karnataka_Btn).wait(1));

	// Layer_1
	this.instance = new lib.Symbol128();
	this.instance.setTransform(210.95,113.65,1,1,0,0,0,24.9,85.8);
	new cjs.ButtonHelper(this.instance, 0, 1, 2, false, new lib.Symbol128(), 3);

	this.lakshadweep_Btn = new lib.Symbol120();
	this.lakshadweep_Btn.name = "lakshadweep_Btn";
	this.lakshadweep_Btn.setTransform(-244.15,138.5,1,1,0,0,0,41.4,10.8);
	new cjs.ButtonHelper(this.lakshadweep_Btn, 0, 1, 2, false, new lib.Symbol120(), 3);

	this.delhi_Btn = new lib.Symbol119();
	this.delhi_Btn.name = "delhi_Btn";
	this.delhi_Btn.setTransform(-160.35,-184.4,1,1,0,0,0,106.4,15.7);
	new cjs.ButtonHelper(this.delhi_Btn, 0, 1, 2, false, new lib.Symbol119(), 3);

	this.haryana_Btn = new lib.Symbol118();
	this.haryana_Btn.name = "haryana_Btn";
	this.haryana_Btn.setTransform(-153.65,-201.2,1,1,0,0,0,98.1,29.6);
	new cjs.ButtonHelper(this.haryana_Btn, 0, 1, 2, false, new lib.Symbol118(), 3);

	this.tripura_Btn = new lib.Symbol111();
	this.tripura_Btn.name = "tripura_Btn";
	this.tripura_Btn.setTransform(210,-78.45,1,1,0,0,0,48.9,35.8);
	new cjs.ButtonHelper(this.tripura_Btn, 0, 1, 2, false, new lib.Symbol111(), 3);

	this.mizoram_Btn = new lib.Symbol110();
	this.mizoram_Btn.name = "mizoram_Btn";
	this.mizoram_Btn.setTransform(257.65,-100.85,1,1,0,0,0,73.6,21.6);
	new cjs.ButtonHelper(this.mizoram_Btn, 0, 1, 2, false, new lib.Symbol110(), 3);

	this.manipur_Btn = new lib.Symbol109();
	this.manipur_Btn.name = "manipur_Btn";
	this.manipur_Btn.setTransform(269.25,-129.5,1,1,0,0,0,73.2,17.9);
	new cjs.ButtonHelper(this.manipur_Btn, 0, 1, 2, false, new lib.Symbol109(), 3);

	this.arunachalPradesh_Btn = new lib.Symbol108();
	this.arunachalPradesh_Btn.name = "arunachalPradesh_Btn";
	this.arunachalPradesh_Btn.setTransform(281.8,-191.15,1,1,0,0,0,114.5,31.4);
	new cjs.ButtonHelper(this.arunachalPradesh_Btn, 0, 1, 2, false, new lib.Symbol108(), 3);

	this.nagaland_Btn = new lib.Symbol107();
	this.nagaland_Btn.name = "nagaland_Btn";
	this.nagaland_Btn.setTransform(273.4,-155.85,1,1,0,0,0,71.2,18.1);
	new cjs.ButtonHelper(this.nagaland_Btn, 0, 1, 2, false, new lib.Symbol107(), 3);

	this.assam_Btn = new lib.Symbol106();
	this.assam_Btn.name = "assam_Btn";
	this.assam_Btn.setTransform(247.5,-151.5,1,1,0,0,0,110.5,39.8);
	new cjs.ButtonHelper(this.assam_Btn, 0, 1, 2, false, new lib.Symbol106(), 3);

	this.meghalaya_Btn = new lib.Symbol105();
	this.meghalaya_Btn.name = "meghalaya_Btn";
	this.meghalaya_Btn.setTransform(144.4,-185.45,1,1,0,0,0,27.7,54.3);
	new cjs.ButtonHelper(this.meghalaya_Btn, 0, 1, 2, false, new lib.Symbol105(), 3);

	this.sikkim_Btn = new lib.Symbol104();
	this.sikkim_Btn.name = "sikkim_Btn";
	this.sikkim_Btn.setTransform(135.85,-190.55,1,1,0,0,0,34.1,25.9);
	new cjs.ButtonHelper(this.sikkim_Btn, 0, 1, 2, false, new lib.Symbol104(), 3);

	this.kerela_Btn = new lib.Symbol97();
	this.kerela_Btn.name = "kerela_Btn";
	this.kerela_Btn.setTransform(-122.25,136.25,1,1,0,0,0,57.2,41.6);
	new cjs.ButtonHelper(this.kerela_Btn, 0, 1, 2, false, new lib.Symbol97(), 3);

	this.j_k_Btn = new lib.Symbol88();
	this.j_k_Btn.name = "j_k_Btn";
	this.j_k_Btn.setTransform(-127,-309.65,1,1,0,0,0,115.7,32.4);
	new cjs.ButtonHelper(this.j_k_Btn, 0, 1, 2, false, new lib.Symbol88(), 3);

	this.goa_Btn = new lib.Symbol87();
	this.goa_Btn.name = "goa_Btn";
	this.goa_Btn.setTransform(-152.2,28.9,1,1,0,0,0,34.3,-9.3);
	new cjs.ButtonHelper(this.goa_Btn, 0, 1, 2, false, new lib.Symbol87(), 3);

	this.andman_Btn = new lib.Symbol84();
	this.andman_Btn.name = "andman_Btn";
	this.andman_Btn.setTransform(190.55,93.6,1,1,0,0,0,23.6,65.5);
	new cjs.ButtonHelper(this.andman_Btn, 0, 1, 2, false, new lib.Symbol84(), 3);

	this.shape_3 = new cjs.Shape();
	this.shape_3.graphics.f().s("#CDCDB4").ss(2,1,1).p("ADyAAInjAA");
	this.shape_3.setTransform(-125.475,-224.75);

	this.shape_4 = new cjs.Shape();
	this.shape_4.graphics.f().s("#B5FF00").ss(2,1,1).p("ADsAAInXAA");
	this.shape_4.setTransform(-82.375,90.55);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_4},{t:this.shape_3},{t:this.andman_Btn},{t:this.goa_Btn},{t:this.j_k_Btn},{t:this.kerela_Btn},{t:this.sikkim_Btn},{t:this.meghalaya_Btn},{t:this.assam_Btn},{t:this.nagaland_Btn},{t:this.arunachalPradesh_Btn},{t:this.manipur_Btn},{t:this.mizoram_Btn},{t:this.tripura_Btn},{t:this.haryana_Btn},{t:this.delhi_Btn},{t:this.lakshadweep_Btn},{t:this.instance}]}).wait(1));

	// Layer_26709
	this.top_mc = new lib.sprite1179();
	this.top_mc.name = "top_mc";
	this.top_mc.setTransform(-316.3,-540.65);

	this.timeline.addTween(cjs.Tween.get(this.top_mc).wait(1));

	// Layer_6
	this.himachal_Btn = new lib.Symbol89();
	this.himachal_Btn.name = "himachal_Btn";
	this.himachal_Btn.setTransform(-8.75,-245.75,1,1,0,0,0,74.5,25.3);
	new cjs.ButtonHelper(this.himachal_Btn, 0, 1, 2, false, new lib.Symbol89(), 3);

	this.timeline.addTween(cjs.Tween.get(this.himachal_Btn).wait(1));

	// Layer_25799
	this.uttarakhand_Btn = new lib.Symbol91();
	this.uttarakhand_Btn.name = "uttarakhand_Btn";
	this.uttarakhand_Btn.setTransform(1.2,-223.1,1,1,0,0,0,55.2,16.7);
	new cjs.ButtonHelper(this.uttarakhand_Btn, 0, 1, 2, false, new lib.Symbol91(), 3);

	this.instance_1 = new lib.sprite1161();
	this.instance_1.setTransform(-66.95,-309.1,0.6,0.6);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_1},{t:this.uttarakhand_Btn}]}).wait(1));

	// Jammu___Kashmir
	this.text = new cjs.Text("State Designated Agencies in India", "33px 'Impact'", "#003399");
	this.text.textAlign = "center";
	this.text.lineHeight = 40;
	this.text.parent = this;
	this.text.setTransform(187.22,-315.85,0.586,0.586);

	this.shape_5 = new cjs.Shape();
	this.shape_5.graphics.f().s("#999999").ss(2.1,1,1).p("A2ui2MAtdAAAIAAFtMgtdAAAg");
	this.shape_5.setTransform(186.625,-304.5);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_5},{t:this.text}]}).wait(1));

	// Layer_7
	this.utterPradesh_Btn = new lib.Symbol92();
	this.utterPradesh_Btn.name = "utterPradesh_Btn";
	this.utterPradesh_Btn.setTransform(-3.3,-162.5,1,1,0,0,0,60.6,59);
	new cjs.ButtonHelper(this.utterPradesh_Btn, 0, 1, 2, false, new lib.Symbol92(), 3);

	this.timeline.addTween(cjs.Tween.get(this.utterPradesh_Btn).wait(1));

	// Layer_21246
	this.madhyaPradesh_Btn = new lib.Symbol112();
	this.madhyaPradesh_Btn.name = "madhyaPradesh_Btn";
	this.madhyaPradesh_Btn.setTransform(-41.4,-106.15,1,1,0,0,0,75.5,51);
	new cjs.ButtonHelper(this.madhyaPradesh_Btn, 0, 1, 2, false, new lib.Symbol112(), 3);

	this.timeline.addTween(cjs.Tween.get(this.madhyaPradesh_Btn).wait(1));

	// Punjab
	this.punjab_Btn = new lib.Symbol117();
	this.punjab_Btn.name = "punjab_Btn";
	this.punjab_Btn.setTransform(-108.4,-233.85,1,1,0,0,0,43.9,24.8);
	new cjs.ButtonHelper(this.punjab_Btn, 0, 1, 2, false, new lib.Symbol117(), 3);

	this.timeline.addTween(cjs.Tween.get(this.punjab_Btn).wait(1));

	// Layer_3
	this.gujrat_Btn = new lib.Symbol114();
	this.gujrat_Btn.name = "gujrat_Btn";
	this.gujrat_Btn.setTransform(-185.55,-82.2,1,1,0,0,0,74.7,41.3);
	new cjs.ButtonHelper(this.gujrat_Btn, 0, 1, 2, false, new lib.Symbol114(), 3);

	this.timeline.addTween(cjs.Tween.get(this.gujrat_Btn).wait(1));

	// Rajasthan
	this.rajsthan_Btn = new lib.Symbol113();
	this.rajsthan_Btn.name = "rajsthan_Btn";
	this.rajsthan_Btn.setTransform(-117.85,-154.05,1,1,0,0,0,70.5,64.5);
	new cjs.ButtonHelper(this.rajsthan_Btn, 0, 1, 2, false, new lib.Symbol113(), 3);

	this.timeline.addTween(cjs.Tween.get(this.rajsthan_Btn).wait(1));

	// Layer_24887
	this.instance_2 = new lib.sprite545();
	this.instance_2.setTransform(-68.8,-198,0.5,0.5);

	this.timeline.addTween(cjs.Tween.get(this.instance_2).wait(1));

	// Layer_23980
	this.instance_3 = new lib.sprite87();
	this.instance_3.setTransform(-51.2,-211.55,0.6,0.6);

	this.timeline.addTween(cjs.Tween.get(this.instance_3).wait(1));

	// Layer_23065
	this.maharashtra_Btn = new lib.Symbol98();
	this.maharashtra_Btn.name = "maharashtra_Btn";
	this.maharashtra_Btn.setTransform(-73.9,-14.15,1,1,0,0,0,70,57.5);
	new cjs.ButtonHelper(this.maharashtra_Btn, 0, 1, 2, false, new lib.Symbol98(), 3);

	this.instance_4 = new lib.sprite88();
	this.instance_4.setTransform(-122.6,-27.4,0.6408,0.6408);

	this.instance_5 = new lib.sprite545();
	this.instance_5.setTransform(-139.45,-24.8,0.6,0.6);

	this.instance_6 = new lib.sprite87();
	this.instance_6.setTransform(-135.95,-5.15,0.6,0.6);

	this.instance_7 = new lib.sprite1115();
	this.instance_7.setTransform(-132.8,7.2,0.6,0.6);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_7},{t:this.instance_6},{t:this.instance_5},{t:this.instance_4},{t:this.maharashtra_Btn}]}).wait(1));

	// Layer_22156
	this.chattisgarh_Btn = new lib.Symbol95();
	this.chattisgarh_Btn.name = "chattisgarh_Btn";
	this.chattisgarh_Btn.setTransform(91.75,-51.6,1,1,0,0,0,106.6,57.1);
	new cjs.ButtonHelper(this.chattisgarh_Btn, 0, 1, 2, false, new lib.Symbol95(), 3);

	this.instance_8 = new lib.sprite87();
	this.instance_8.setTransform(5.8,-56.8,0.6,0.6);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_8},{t:this.chattisgarh_Btn}]}).wait(1));

	// Layer_20324
	this.instance_9 = new lib.sprite865();
	this.instance_9.setTransform(191.8,-145.6,0.6,0.6);

	this.timeline.addTween(cjs.Tween.get(this.instance_9).wait(1));

	// Layer_19410
	this.jharkhand_Btn = new lib.Symbol93();
	this.jharkhand_Btn.name = "jharkhand_Btn";
	this.jharkhand_Btn.setTransform(65.75,-136.5,1,1,0,0,0,46.4,65.9);
	new cjs.ButtonHelper(this.jharkhand_Btn, 0, 1, 2, false, new lib.Symbol93(), 3);

	this.instance_10 = new lib.sprite1022();
	this.instance_10.setTransform(114.75,-174.8,0.6559,0.6559);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_10},{t:this.jharkhand_Btn}]}).wait(1));

	// Layer_9
	this.instance_11 = new lib.sprite545();
	this.instance_11.setTransform(-24.6,151.2,0.6,0.6);

	this.instance_12 = new lib.sprite87();
	this.instance_12.setTransform(-39.55,156.3,0.6,0.6);

	this.pudo_btn = new lib.button687();
	this.pudo_btn.name = "pudo_btn";
	this.pudo_btn.setTransform(-65.55,113.5);
	new cjs.ButtonHelper(this.pudo_btn, 0, 1, 2, false, new lib.button687(), 3);

	this.tamilNadu_Btn = new lib.Symbol99();
	this.tamilNadu_Btn.name = "tamilNadu_Btn";
	this.tamilNadu_Btn.setTransform(-52.6,134.35,1,1,0,0,0,74,51.6);
	new cjs.ButtonHelper(this.tamilNadu_Btn, 0, 1, 2, false, new lib.Symbol99(), 3);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.tamilNadu_Btn},{t:this.pudo_btn},{t:this.instance_12},{t:this.instance_11}]}).wait(1));

	// Layer_19368
	this.instance_13 = new lib.sprite88();
	this.instance_13.setTransform(147.1,-142.25,0.6559,0.6559);

	this.instance_14 = new lib.shape1034UpOverDownHit("synched",0);
	this.instance_14.setTransform(142.5,-150.15);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_14},{t:this.instance_13}]}).wait(1));

	// Layer_18445
	this.instance_15 = new lib.sprite1022();
	this.instance_15.setTransform(171,-108.75,0.6559,0.6559);

	this.instance_16 = new lib.sprite1018();
	this.instance_16.setTransform(135.45,-106.4);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_16},{t:this.instance_15}]}).wait(1));

	// Layer_17489
	this.instance_17 = new lib.sprite88();
	this.instance_17.setTransform(185.05,-115.85,0.6559,0.6559);

	this.instance_18 = new lib.shape954UpOverDownHit("synched",0);
	this.instance_18.setTransform(184.2,-122.6);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_18},{t:this.instance_17}]}).wait(1));

	// Layer_16568
	this.instance_19 = new lib.sprite88();
	this.instance_19.setTransform(200.65,-139.5,0.6559,0.6559);

	this.instance_20 = new lib.shape938UpOverDownHit("synched",0);
	this.instance_20.setTransform(196.05,-147.4);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_20},{t:this.instance_19}]}).wait(1));

	// Layer_15653
	this.instance_21 = new lib.sprite926();
	this.instance_21.setTransform(203.2,-167.35,0.6559,0.6559);

	this.instance_22 = new lib.shape921UpOverDownHit("synched",0);
	this.instance_22.setTransform(202.35,-174.1);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_22},{t:this.instance_21}]}).wait(1));

	// Layer_15651
	this.instance_23 = new lib.sprite920();
	this.instance_23.setTransform(202.1,-174.1);

	this.timeline.addTween(cjs.Tween.get(this.instance_23).wait(1));

	// Layer_14740
	this.instance_24 = new lib.sprite908();
	this.instance_24.setTransform(-121.75,26,0.6,0.6);

	this.instance_25 = new lib.sprite865();
	this.instance_25.setTransform(-136.7,31.1,0.6,0.6);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_25},{t:this.instance_24}]}).wait(1));

	// Layer_14735
	this.assam_mc = new lib.sprite902();
	this.assam_mc.name = "assam_mc";
	this.assam_mc.setTransform(-176.1,8.5);

	this.timeline.addTween(cjs.Tween.get(this.assam_mc).wait(1));

	// Layer_13814
	this.instance_26 = new lib.sprite865();
	this.instance_26.setTransform(194.65,-140.7,0.6,0.6);

	this.timeline.addTween(cjs.Tween.get(this.instance_26).wait(1));

	// Layer_12883
	this.instance_27 = new lib.sprite835();
	this.instance_27.setTransform(-74.1,-266.7,0.6559,0.6559);

	this.timeline.addTween(cjs.Tween.get(this.instance_27).wait(1));

	// Layer_11972
	this.instance_28 = new lib.sprite545();
	this.instance_28.setTransform(-78.45,-208.05,0.55,0.55);

	this.instance_29 = new lib.sprite87();
	this.instance_29.setTransform(-84.75,-196.8,0.55,0.55);

	this.instance_30 = new lib.sprite815();
	this.instance_30.setTransform(-80.2,-193.6,0.55,0.55);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_30},{t:this.instance_29},{t:this.instance_28}]}).wait(1));

	// Layer_2
	this.instance_31 = new lib.shape830UpOverDownHit("synched",0);
	this.instance_31.setTransform(-83.25,-271.35);

	this.timeline.addTween(cjs.Tween.get(this.instance_31).wait(1));

	// Layer_10143
	this.instance_32 = new lib.sprite87();
	this.instance_32.setTransform(106.5,-90.4,0.6,0.6);

	this.instance_33 = new lib.shape772UpOverDownHit("synched",0);
	this.instance_33.setTransform(79.15,-166.95);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_33},{t:this.instance_32}]}).wait(1));

	// Layer_9223
	this.instance_34 = new lib.sprite757();
	this.instance_34.setTransform(58.3,-104.35,0.6681,0.6681);

	this.timeline.addTween(cjs.Tween.get(this.instance_34).wait(1));

	// Layer_8312
	this.instance_35 = new lib.shape736("synched",0);
	this.instance_35.setTransform(21.2,-66);

	this.timeline.addTween(cjs.Tween.get(this.instance_35).wait(1));

	// Layer_6469
	this.instance_36 = new lib.sprite699();
	this.instance_36.setTransform(-71.45,141.2,0.6,0.6);

	this.timeline.addTween(cjs.Tween.get(this.instance_36).wait(1));

	// Layer_5506
	this.instance_37 = new lib.sprite545();
	this.instance_37.setTransform(-43.55,121.2,0.6,0.6);

	this.instance_38 = new lib.sprite87();
	this.instance_38.setTransform(-58.5,126.3,0.6,0.6);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_38},{t:this.instance_37}]}).wait(1));

	// Layer_4596
	this.instance_39 = new lib.sprite643();
	this.instance_39.setTransform(-139.25,45.95);

	this.instance_40 = new lib.sprite545();
	this.instance_40.setTransform(-90.1,70.25,0.6,0.6);

	this.instance_41 = new lib.sprite87();
	this.instance_41.setTransform(-105.05,75.35,0.6,0.6);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_41},{t:this.instance_40},{t:this.instance_39}]}).wait(1));

	// Layer_1819
	this.instance_42 = new lib.shape557("synched",0);
	this.instance_42.setTransform(21.2,-66);

	this.timeline.addTween(cjs.Tween.get(this.instance_42).wait(1));

	// Layer_910
	this.instance_43 = new lib.sprite88();
	this.instance_43.setTransform(-168.55,-81.7,0.6575,0.6575);

	this.instance_44 = new lib.sprite545();
	this.instance_44.setTransform(-158.35,-95.3,0.6,0.6);

	this.instance_45 = new lib.sprite87();
	this.instance_45.setTransform(-173.3,-90.2,0.6,0.6);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_45},{t:this.instance_44},{t:this.instance_43}]}).wait(1));

	this._renderFirstFrame();

}).prototype = getMCSymbolPrototype(lib.sprite1180, new cjs.Rectangle(-324.8,-344,721.2,549.6), null);


// stage content:
(lib.homepagemap = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	this.actionFrames = [0];
	this.isSingleFrame = false;
	// timeline functions:
	this.frame_0 = function() {
		if(this.isSingleFrame) {
			return;
		}
		if(this.totalFrames == 1) {
			this.isSingleFrame = true;
		}
		this.clearAllSoundStreams();
		 
		this.stop()
		stage.enableMouseOver();
		stage.snapToPixelEnabled = true;
	}

	// actions tween:
	this.timeline.addTween(cjs.Tween.get(this).call(this.frame_0).wait(1));

	// Layer_3
	this.movie11 = new lib.Symbol85();
	this.movie11.name = "movie11";
	this.movie11.setTransform(634.2,399.75);

	this.timeline.addTween(cjs.Tween.get(this.movie11).wait(1));

	// Layer_1
	this.instance = new lib.sprite1180();
	this.instance.setTransform(367.55,382.9,1.0215,1.0215);
	this.instance.shadow = new cjs.Shadow("#FFFFFF",0,0,0);
	this.instance.cache(-327,-346,725,554);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));

	// Layer_2
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#000000").ss(1,0,0,3,true).p("AiEp2IAAAAAiCp1IgCgBQgUAkAIBKAgBmVIgDgCIAKgKACjk5QgCACgBACQgBACAAADIgBAZQAAAFgEACIgNAIIgUAEQgPACgKAHIgHAFQgJAGgJAJIgjAiIhFADQgDABgIAFIgIADQgFABgDALQgBALgNAHQgLAKgTACIgNABIgQAHQgPACgOAFIgHAEQgIAGgNgBIgrABQgMAAgEANIgFAKQgFAIACAKQABAGgEADIgMAIQgMAMgTAAQgLgBABAHQABAHgJAGIhWACQgNAAgKAFQgNAGgHAMIgIAFQgGAEgFAGQgFAFgGgBIgbgEIgTgKQgLgDgMAAIgBADIABAAQAMAAAMAEIATAKIAaADQAHACAFgFQAFgGAGgEIAIgGQAAAAABAAQAHgLAMgGQALgFAMAAIBWgDQAJgGgBgGQAAgHAKAAQATABAMgNIAMgIQAEgCgBgGQgBgKAFgJIAEgJQAEgOAMAAIArgBQANABAIgFIAHgEQAOgFAQgDIAPgGIAMgCQAUgBALgLQANgGABgLQADgLAFgCIAIgDQAIgEADgCIBFgCIAjgjQAJgJAJgGIAHgEQAKgHAPgCIAUgFIANgHQAEgCAAgFIABgZQgBgJALgEAAvlJIAAgkAgEmuIABgHAFCmfQgDgHABgMAKnofIgdA5QglAtgmA3IgsAKQg5AbgVA7Ig/A+QgegHhKBDIADAbQAPAAAFAKQAGAMgJAaQhYBEhmgfQgOAPgEAjQgEA9g5ANQgOgygfATQgyAkgbA2IALEfIAYADIgEApIgcAAIgMAPAn8oZQAEALANAIIAOAHAo4k5IAMAVIARAWAo4k6IAAABQgBgBAAAAApJhNQAfASAGAVApBipQASAOAEARAp5BhIAKAWQABADABACIAIARIAAABAmNHRIgBgDQglgLgvhHIg9AwIg0gXIguAIIgWg0AqmEaIAfAfIAvgLIAdAQIAAADAhtHqIgYAcIhFgMQgQA0gZgTIgLAgIhTgNIglBCQgjARgNgUIgCgCAmLH/IAiAOIgCADAl9InQABACAAAC");
	this.shape.setTransform(364.9964,423.7087);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f().s("#000000").ss(1,1,1,3,true).p("AjYiYIgSgBIABgoIgMABIACgnIAKgNIgUgTIgpAAIgcgfIgDgTIAUgVIAWABIAJAKIATABIATgUIAWgMIApACIATgWIAAgTIAegeIAngDIADgdIAUgoIAdgTIAEgBIAtAAIApggIAXg6IBSgqIAmAVIApAAIAIAKIAVAAIA/hIIA8ABIAbAfIgnApIgBAIIAfABIAUgVIAKAAIAKAKIABAVIgLALIAAAcIgKACIgLAVIABAQIAKAMIAAACIASgBIAjgVIARACIANAIIAdABIAHALIALAAIAUAVIAKATIAAAJIAgAcIAIAQIgBAYIgTAAIgIAOIgCBGIhGAAIAAgKIgSAAIgDgMIgJABIgCAJIgIABIgCAHIgbACIgNAUIgSAAIgDAMIgRgCIgBAMIgKgBIgBAKIgIABIgCAHIgTADIAAALIgTAAIgBAQIgBABIABgRIgGgKQgBgBgBgCQgDgFgEgFQgfAagnALQhQAzgZAaQgJAJgCAGIABABQAAAAABABIgDADQABADACABQg5A5ABAbQgHAGgBAOQgBABAAACIACAJIAAABIAAAHIgsgHIgRAUIgBAbIAAAGIAIAFIAAgHIABAAIAAAHIAAAAIAAAXIAAAHIABAHIACABIAAABIAFABIAAgCIAUgQIADgTIAIgDIAMgRIAygDIADAEQABABAAABIAFAHIAUgCIAAgeIAfgRIAAABIABAAIABAuIAHAAIAAADIAAAAIACAJAFBmMQgGgTALgIIABAAQANABAOAAIAbABIgUAnIgBApQAaAVARAAIgDAZIgBAAIgBABIgbABIgNAPIgNAOIgJAHIAPAXIAAACAFimmIAaACIgUAmIgBAqQAbAVAPAAIgCAYAFzklIgBAAIgMAPAEnmNQAHgDATAFIAAgBQgUgFgGAEgADrluQAUgLAagNIAHgDIABAAIABAAAElmLQgCABgBABQABgBABgBIABAAQABgBABgBADrluQAAABAAAAIgtACADrluIgtACIAAABIAAAAQAAAcgSANQgFgFgLAEIgHADQAAAAgBAAQABgSgSAFQgBAAAAAAQgHAQgRAHQAAAAAAAAIAAAWIAAABQgGgBgJAFQgLAFgOAOIgQASQAEAdgUAOQgXANgugCIAAAAIgKALIAAABIhugDIgCABQgBAAgCABIgrAXQgHADgGADACslCIgBAAQgFgFgKAEAFQkBQAAABgBABAFUjRIgCABIABAXIAAACIgKACIAAAcIgCAAAFUjRIAAAYIgBAAAFJi1IgBAAIgBAcIAAABIgIACIAAAQIgBABIAAABIgJABIgCAAIgBASIAAABIgGABIgCAAIAAAdABqkgQgGAAgJAFAgjjAIAAgBQAuACAXgMAAaAvIAIAEAAiA6IABAAABYgBIAAAAIAAABIAAAAABXgNIABAMAE/iWIgCAAIABARAE1iDIgBARIgCABAEXhHIgDAAIAAATIAAABIgKAAIACATIgCAAIAAAAIgJABIgCAAIABATAEghRIgCAAIAAAJAEghRIgCAJIAAAAIgBABIgGAAIgBATIgCAAAEKgzIgBAAIABATAEshvIgBAdIgBAAIAAABIgKAAACUh8QAAACAAABACVh+QgBABAAABQABgBABAAADsAeIgBAAIAAAIIAAABIgGAAIgBATIgCAAADsAeIAAAIIgBAAADlAnIgDAAIAAATIAAABIgTADIAAgBIgBAAIgBgJADGAxIgCAAIAAguADOA9IAAAWIAJAAIAAATIAKADIAAAIIAJABIAAAyIAMgBIgBAzIAKAAIABAPIg8ACIgBAHIgKABIAAATIgKACIAAAfIgKAAIAAA9Ig7ABIACgOIg+ACIAAgKIgRAAIgDgKIgNAAIACAWIAJACIABASIAKABIAAASIAJAEIACBRIgBABIAAABIgKAFIgBAbIgBABIgcAYIABBYIATAEIAAAgIgBABIAAggIgUgDIAAhaIABAAAEBgfIABATIgCAAIAAABIgIAAIAAAmIgCABIAAAAIgKACAD4gLIgCAAIAAAnACVlAQABgTgTAGAArBiIAAABIgFACIgDgCIAAAJIgbABIABAyIghAoIABAxIgGAMIAHAKIACAKIAHAAIAAAMIAaAdAgdEEIgBACIgIAMIgPAFIgMgHIgIAAIgJAdIgWAXIgYgDIgYAlIAFAFIAAADIAJALIAABPIAJgBIAFAPIAEABIAAAIIgCAHIgUACIAAAIIgeABIAAAJIgTABIAAAJIgSACIgDAKIg4ABIgMgIIAAgXIgdAAIAAhoQATgmAXgSIBdABIAAgCQAPgfAJgFIAFgCIACgrIgFgCQgZgMAGgxIAsAcIgCg/IADgFIAegjIgmhIIg8ADIgPgVQAdgRgMggIgUAJIgzAAAgeEGIAGAKIACAJIAHAAIAAAMIAaAeIAAAAIADAVIAJADIABARIAKACIAAASIAJAEIACBQAAhH2IABgbIABgBAFdjXIgJAGAAjBRIADAPAAjBYIAAALAgti1IhtgCIgBAAAogAcIgDAAIgZALIgeg+IAKgCIAEgbIAJgFIAEgsIBagqIAUALIBRAAIAHgJIA6gBIASgKIBUAAQAAAAABAAAlHArIgFAFIgjAAIgVgTIg8gBIgOgLIgNAAIgCAAIgHAGAlHArIACAAIBCg3IgBAAgApzh6IgDAAAh6CZIgXACIAAgLIgUAAIgDgKIg9gBIAAAKIgfABIAAAJIiJACIgBAKIhJgBIgBgJIgcADIhFgeIgGg9IAHgJIAIgFIACgOIAIgFIAGgGAnbARIgHAGIgCAAIgFAFIg3AAAiZFnIgCADIgWgTIADgEAiYFmIgBABIAGAHAiKHIIAAANIAKAAIAEABAgBKuIgBACIgjABIg9g3IABgVIAKgXIghhvAALKdIgLARIgBAAgAAYKLIgNAS");
	this.shape_1.setTransform(572.9,238);

	this.shape_2 = new cjs.Shape();
	this.shape_2.graphics.f("#000000").s().p("EgORApiIhjhNIA4ABIABgFIgkgBQg0gcAEhqQgzgBgLhzQAqgQgVhCIgvAXIAHhiQgugigJhjQh5iKgwiWIAAgBIgBgDIgZgCIgBgWQgKjZg/g8QgFg6gVgoIgBABIgNgTQgKgPgJgRIgGgMQgJgQgHgRIgEgKIgPgjIAAgBIABAAIgBgEIgBAAIgwhJIgtkTIgkhzIgBhmIAVgZIgegUIAAiSIgLgJIAKg1IAPgHIgQAHIAbhvIgbg1IgJhDIAZgWIAAgmIgegIIgMhgQgXACgKAXQgGANgDAVIAAACQAUArgLA2QgUA3g3AMIAAADIjFAvQhCgshFhcQgrgpghgnIgdgiQgcgkgTgiQARgeALAJQANAnAcADIBdggQBngcABg3Qg0AXiIgBQg9gqgkgtQgXgcgOgcQAYgGANgLIAJgLIgJgMIgaAAQg4ArAIhQIBhgDIgIgvIAmgYIAzATIBCAAIAVAgIAkAAIAdgoIBZgMIAPAjQAtgLAIg7IAAAAQgCgUgLgLQgHgugigVIgNhZQgjAigkgyIAOh5IgYgRIgqgIIgpgnIAJg0IAAgeQBDghBLhjIA8AMIAFA0IAmADQAmgnBPABQA6gSgFgxQAtgmAsg9IBRgnQAPg0AmgfIANg9QAXgXAWgJQATgIASADIABACIgCgMQAfhBAzgrIAigDIAbghIgYgRQAAgRAOgOIAAgsQgUgQARggIA9gpIAlgCIAagiIABgBQgQgVhKgMIgCg+QhRANgQgmIgCgEQgcABgWgWQgMgMgKgWIgBguIAVgXIgVgeIABhaIgUgsIA+g5IAfADIASgeIg0gtIACgzIg+ghIgyguQgrALgRghIgBg6IAlACIA6hDIAfgGIAQALIBCAAIgQglIBPgDIAFgLIAnAAIALgKIAXgBIAQANIAngBIALgKQAuAuAeAtQBAAVAVAUIAiAdQAKAPAOAHQAQBABXAWIACAsIAmABQCOgzAAgVIBcAAQAYgvApA7QA1gFAFAFIAyAvQACAqgOgBQgMCXhcANQgHAegLAbIgVABIgBAJIgmAAIAAALIgVAAQABAOgCAIIALAAIgBAgIAKABIAAAPIgTAAIAAA1IBEAEIAABOIAMABIABAJIAJABIABAjIgVAAIAAAMIgeAAIgBAJIgUABIgBAIIgGADIgDAJIgjAAIAAgMIgMACIgBgpIggAAIgDAiQgiAAgRgsQgPAGgOgLQAOAMAPgHQARAsAiABIADAdIAdATIABAUIAKgBIABAeIgJABIABASIAaADIALALIABAnIAZAFQAZA+AmAQIAogBIApAnQAcASAdAiQAPAFAUgFQAJALAlAdQgBAFAHAGQgTAJgRACIgMAwQgNAdgqgBIAAAkIgZAUIAABEIgVAPIgBAcIAzApIAsAGIAUAAIAmAeIAKgBIALAKIAAAKIAtAhIAHAAIApAoIAoAAIAJAJIAUAAIAMALIAKAAIASATIAwABIAVAoIAhAAIAIALIAVAAIAIAIIAOAAIASgTIAsADIAkAlIgSgWIAIgeIA0ABIBEArIADAdIAJAJIATAAIA+AoIAfABIAJgKIAeAAIATAUIABAMIAMAJIAIAAIAegVIASAAIABAJIAeABIAjAUIBDAAIALgKIAdAcIAqAAIAJgHIAyAAIALgKIAcgBIALgIIACgKQgHgZAHgnQgQgKgGgLIgCgFQAKgGABgHIgJgCIgGgOIgBgQIgMAAIAAgdIAMgSIAJgKIAAg/IAggTIAdgBIACgLIAZADIAYARIgJAMIABAvIAGAKIgHATIAIAIIgBARIAMAIIABAMQgGADgEAOIAnAsIASAAIAVAWIAegBIAKgMIAVAAIAqApIAGgCIAAAaIgIAEIgFAcIgZAEIgBAKIgNABIAAAbIgcACIgjghIgDgSIgKgDIgBgTIgWACIgBARIgIACIgKAQIgMAJQgTgLADggQgHgCgEgKQgGgBgCgJIgjgCQgFAhAZAGQADARgZARQgQAngPgMQALAlAYAYIASAHQABAWALAGIAogCIALALIASAAIAAAOIAMADIgHAfQgbADAGgNIgiAAQAEAPgagEIACAnIgLALQgQANgXgDIgBArIA+AxIAsALIAGA6IgWANIADAGIgNACIgBAWIAMACIABAJIAIABIAAATIAUABIACAKIAJgBIAAAoIAUACIAABGIAKAAIgBBPIAKABIADAKIAIACIAABAIg9gBIAAAKIgUAAIgBALIgfACQgGgGgDgJQgGgNADgVIAAgGIgdABIgBAFIgMAiQgYAzgrAUIgZgDIAAAEIgDABIAAACIgQAHQgvATgSAUIgEAHIAAAiIAKAEIAAAkIAKAEIAAAtIgCABIAAACIgdANIABASIAKABIABAbIgCABIAAACIgyAYIAAAVIgCACIAAACIgvAhQg5gCgnAnIgoAGIAAgqQgLACgLAFQgRAIgPAPQgCAWALAUIgDADIAAAAQg/AvgfAoIgDACIgdA5QglAtgmA3IgsAKQg5AbgVA7Ig/A+QgegHhIBDIADAbQAPAAAFAKQAFAMgJAaQhYBEhmgfQgOAPgEAjQgEA+g5ANQgOgyggATQgxAkgcA2IAMEfIAXADIgEApIgcAAIgMAPQAnAIAWAbIgBAyQgZAugKBOIg7BQIgDATIAAAJIgCAEIAAADQAJCRgTCFIhOAAQgGAUgOAMQgDAthEBBIADAdIAAAAIAOABIgBAbQglAVhGAEQgaAbgbA3QABAlgWAeQgOASg2AOIgLAcIgYAEgAx4dtIAIgBIgCgDIgGAEgArfbwIACABQAOAUAjgQIAlhDIBTAOIAKggQAZASARg0IBFAMIAWgfIgXAcIhFgMQgRA0gZgTIgKAgIhTgNIglBCQgjARgOgUIgBgCgAtlb5QAPgMATABQANgRAMgIQgbAIggAcgAq1apIACADIgBgEgArCaDIAfAOIADgDIgigOgArFZSIAAgDQglgLgvhHIg+AwIgzgXIguAIIgXg0IAAgBIAXA5IAvgIIAzAXIA+gwQAvBFAkAMgAtyXCIAAgDIgdgQIgvALIgggfIAAACIAhAhIAvgMgAunT4IADAFIAHASIAAgBIgHgRIgDgFIgJgWgA2nShIAAADIABgBIgBgDgAsUSUQAFgBADgDIAAAAQAFgGAGgEIAJgHIAAAAQAIgLAMgGQAKgFANAAIBWgDQAHgFAAgGIAAgBIAAgBQABgGAIAAIAAAAIAAAAIAAAAIABAAIABAAIABAAIAAAAIAAAAQASAAALgMIABAAIALgIQAEgCAAgFIAAgBQgCgKAFgJIAFgJQADgOANAAIAqgBIADAAIABAAIAAAAIABAAQAKAAAGgEIAHgEQAPgFAPgDIAQgGIAMgCQATgBALgLQAOgGAAgLQAEgLAFgCIAIgDIAKgGIBGgCIAjgjQAJgJAKgGIAHgEQAKgHAPgCIATgFIANgHQAFgCAAgFIAAgZIAAgBQAAgIAKgEQgKAEAAAIIAAABIAAAZQAAAFgFACIgNAHIgTAFQgPACgKAHIgHAEQgKAGgJAJIgjAjIhGACIgKAGIgIADQgFACgEALQAAALgOAGQgLALgTABIgMACIgQAGQgPADgPAFIgHAEQgGAEgKAAIgBAAIAAAAIgBAAIgDAAIgqABQgNAAgDAOIgFAJQgFAJACAKIAAABQAAAFgEACIgLAIIgBAAQgLAMgSAAIAAAAIAAAAIgBAAIgBAAIgBAAIAAAAIAAAAIAAAAQgIAAgBAGIAAABIAAABQAAAGgHAFIhWADQgNAAgKAFQgMAGgIALIAAAAIgJAHQgGAEgFAGIAAAAQgDADgFABIAAAAIAAAAIgCgBIgBAAIAAAAIgbgDIgTgKQgLgEgNAAIAAAAIABgEQAMAAALAEIASAKIAbAEIABAAIABAAIABAAIAAAAIABAAQAEAAADgEQAFgGAGgEIAJgGQAHgMANgGQAKgFANAAIBWgCQAHgGAAgGIAAgBIAAgBQAAgFAIAAIABAAIAAAAIAAAAIABAAIABAAIABAAIAAAAIAAAAQASAAAMgMIAMgIQACgCAAgFIAAgCIAAgFQAAgHAEgGIAFgKQAEgNAMAAIArgBIABAAIABAAIAAAAIABAAQALAAAGgFIAHgEQAPgFAPgCIAQgHIAMgBQATgCAMgKQANgHAAgLQAEgLAFgBIAIgDIAKgGIBGgDIAjgiQAKgJAIgGIAIgFQAKgHAPgCIAUgEIAMgIQAFgCAAgFIABgZIAAgCIAAgDIADgEIgDAEIAAADIAAACIgBAZQAAAFgFACIgMAIIgUAEQgPACgKAHIgIAFQgIAGgKAJIgjAiIhGADIgKAGIgIADQgFABgEALQAAALgNAHQgMAKgTACIgMABIgQAHQgPACgPAFIgHAEQgGAFgLAAIgBAAIAAAAIgBAAIgBAAIgrABQgMAAgEANIgFAKQgEAGAAAHIAAAFIAAACQAAAFgCACIgMAIQgMAMgSAAIAAAAIAAAAIgBAAIgBAAIgBAAIAAAAIAAAAIgBAAQgIAAAAAFIAAABIAAABQAAAGgHAGIhWACQgNAAgKAFQgNAGgHAMIgJAGQgGAEgFAGQgDAEgEAAIgBAAIAAAAIgBAAIgBAAIgBAAIgbgEIgSgKQgLgEgMAAIgBAEIAAAAQANAAALAEIATAKIAbADIAAAAIABAAIACABIAAAAIAAAAgAtcRaQgGgVgegSQAeASAGAVgAtiP2QgFgRgRgOQARAOAFARgAtjNcIARAWIgRgWIgNgVIAAgBIgBAAIABABgAkIM3IAAgkgAk7LpIACACIgCgCIAKgKIgKAKgAAKLhQgBgIAAgLIgBAAQAAAMACAHgAk7LSIABgHgAsiJ6IAOAHIgOgHQgNgIgEgLQAEALANAIgAnHJ4QgDgVAAgTQAAgtAOgZIADABIgCgBIgBAAQgOAZAAAtQAAATADAVgAhmGzIADgCIAAAAgA29D9IgFAMIAGgMIgGgMgACNChIABAAIADgGgA2OBHIABAAIACgpgAMAA7IAGgKIgBAAgAGoARIAAABIAFgEgA2EgGIAHgEIAAgBgA2HgnIAIAYIgHgYIAHgEgA1QhBIgEABIAFgBIgBgCgA1jh8IAEAKIACgGIAGgBIgHABIgIgJgABkkEIABAAIgPgKgACCk3IAGAHIgGgHIAHgGgAsRrqQAvgaAYgeIgHAAQgUAegsAagAR0s6IgEAAgAOfttQAYgEAZgLIgTgGQgOAPgQAGgAufuwIADgCIgDgBgAuPu4IAtgYIgJgCQgSAAgSAagAvHvlIAEAAQgEgMgCgJQAAAJACAMgAvcv6QgOgZgUAGIACAAQAUAAAMATgAuVxGIAAgBIgCgBIACACgAupyJIACgCQAAgLANgKIgCgFQgJANgEAPgAuLy2IABAAIABgBIgCABgAyt0nIAAAAIgCgXQgHABgGgDgAxB06IABAAIAAgCIgBAAgAv61QIgHgUIgBAAgA0U1RIgBgPIgBAAgAun3qIAWAeIAMAHIAEgDIgSgNIgVgbgAsO3IIAEACIAAgCIgEgDgAuw4vIAGAsIADACIgHguQgVgHgQgUIgDgBQAQAUAWAIgAp84sIAGAAIgBgEIgFgBgApG5EIAEABIgBgFIgDgBgAw78UIgDABIACAyIAvBaQgIAwA7ALQg4gMAIguIgvhaIgCg0IAdgiIAAgBgAsX9QIAAAAQAFgMAKgGQgKAFgFANgAsX9QQgBgQgqACIgPgUIgXABIgtgsIgsAAIgpArIg0AAIAAAAIA0ABIApgrIAsAAIAtArIAXgBIAPAVQAqgDABAQIAAAAgAtwNHgAaFhFIABgVIAKgXIgihvIAAgJIgDAAIgFgPIgJAAIAAAOIAKAAIAEABIADAAIAAAJIgBAHIgUACIAAAHIgeACIAAAJIgTABIAAAJIgTACIgCAKIg5ABIgLgJIAAgXIgeABIAAhpQATglAYgSIBcAAIgCAFIAWATIACgDIgCADIgWgTIACgFIABgBQAOggAKgFIAEgBIADgrIgGgDQgYgLAGgyIArAdIgCg/IAEgFIAegkIgnhHIg7ADIgPgVQAUgNAAgUQAAgIgDgJIgVAJIgyAAIAyAAIAVgJQADAJAAAIQAAAUgUANIAPAVIA7gDIAnBHIgeAkIgXACIgBgLIgUAAIgCgKIg9gBIgBAKIgfABIAAAJIiIACIgBAKIhJgBIgBgJIgdACIhFgeIgFg8IAHgKIAIgEIABgOIAJgFIAGgHIgDAAIgZAMIgeg/IAKgCIAEgcIAIgEIAFgsIBZgqIAUALIBSAAIAHgJIA6gCIASgJIBUAAIABAAIANgGIAqgXIAEgBIACgBIgCABIgEABIgqAXIgNAGIgSgBIABgoIgNAAIADgmIAKgNIgUgUIgpABIgcgfIgDgUIATgUIAWAAIAKAKIATACIATgUIAVgMIAqABIASgVIAAgUIAfgeIAngCIADgdIAUgoIAdgTIADgBIAuAAIAqggIAWg6IBTgqIAlAVIAqAAIAHAKIAWAAIA+hIIA8ABIAbAfIgnApIAAAIIAfABIATgVIAKAAIALAKIABAVIgMALIABAcIgLACIgKAVIAAAQIAKAMIAAACIATgBIAigVIASACIAMAIIAeABIAHALIALAAIAUAUIAKAUIAAAJIAgAcIAIAQIgBAYIgTAAIgIANIgCBGIhGAAIAAgKIgTAAIgCgLIgJABIgCAJIgIABIgCAHIgbACIgOAUIgSAAIgDALIgRgBIgBALIgKAAIAAAKIgJAAIgBAIIgUACIAAAMIgSgBIAAgBIgPgXIAJgHIANgPIgNAPIgJAHIgBACIAHAKIABADIAHAJIgCASIgJAGIgBAAIABAYIgBgYIABAAIABAYIgBAAIAAABIgKADIgCAAIAAAcIAAAAIgJADIgBAAIAAAQIAAgQIABAAIABAQIgCAAIAAABIgJACIgBAAIgBASIABgSIABAAIAAARIgCABIAAAAIgHACIgBAAIgBAdIABgdIABAAIAAAdIgCAAIAAABIgKAAIgBAAIgBAIIAAACIgHAAIgCAAIAAASIAAgSIACAAIAAASIgCAAIAAACIgKAAIACASIgCAAIgBgSIABAAIgBAAIABASIAAABIgJABIgCAAIABATIgBgTIACAAIAAATIgBAAIAAABIgJAAIABAnIgCAAIAAgnIABAAIgBAAIAAAnIAAABIgKACIgBAAIAAAHIAAgHIABAAIAAAHIgBAAIAAACIgHAAIgCAAIgBATIAAABIgSADIAAgBIgCgKIgBAAIAAgCIgHAAIgBAAIAAguIAAAuIABAAIAHAAIAAACIABAAIACAKIgBAAIgCgKIACAKIgBAVIAJABIABATIAJADIAAAHIAJACIABAyIAMgBIgBAzIAJgBIACAQIg8ABIgBAIIgLABIAAASIgKADIAAAeIgJABIgBA9Ig7ABIACgOIg9ACIgBgKIgRgBIgCgJIgNAAIgcgdIAAgMIgGAAIgCgKIgIgKIAHgMIgCgxIAigoIgBgyIAcgBIAAgJIADABIAEgBIABgCIAAgBIAUgQIADgUIAHgDIANgRIAygCIADAEIABACIAEAGIAUgBIAAgeIAggSIAAACIAAgCIggASIAAAeIgUABIgEgGIgBgCIgDgEIgyACIgNARIgHADIgDAUIgUAQIAAABIgGAAIAAgCIgCgOIACAOIgBAAIgBgIIAAgGIAAAGIAAAMIAAAJIgcABIABAyIgiAoIACAxIgHAMIAIAKIACAKIAGAAIAAAMIAcAdIACAVIAJADIAAASIALABIAAASIAJAEIACBRIgCABIgBhQIgJgFIAAgRIgLgCIgBgRIgJgDIgCgVIgBAAIgageIAAgMIgHAAIgCgJIgGgKIAGAKIACAJIAHAAIAAAMIAaAeIABAAIACAVIAJADIABARIALACIAAARIAJAFIABBQIAAAAIgJAGIgBABIgBAbIgcAXIgBABIAABaIAUADIgBAgIABggIgUgDIAAhaIABgBIAABZIAUAEIgBAgIgBABIgMASIgNARIgBABIgjABgAZOlYIAGAHIAIALIABBOIgBhOIgIgLIAAgDIgFgFgAZPlZIAYglIAYADIAWgXIAIgdIAIAAIAMAHIAQgFIAIgMIAAgCIAAACIgIAMIgQAFIgMgHIgIAAIgIAdIgWAXIgYgDgAcLpuIAAgXIgBAAIABAAgAcCqRIAAAHIAIAEIAAABIAAgBIAAgHIAAABIAAAHIAAgHIAAgBIgIgEIABgaIARgVIAsAIIgBgHIABAAIAAgCIgBgMQAAgOAHgHIAAgBQAAgaA5g4QgDgBAAgDIACgDIgBgBIAAgBIgBACIABgBIABABIgCADQAAADADABQg5A4AAAaIAAABQgHAHAAAOIgBADIABAJIAAACIABAHIgsgIIgRAVIgBAagAetqOIAAguIgBAAIABAAgAUZquIAOALIA7ABIAWATIAjAAIAFgFIACAAIBCg4IgCAAIhCA4IgFAFIgjAAIgWgTIg7gBIgOgLIgOAAgAT+qkIAFgEIgFAEIg3AAgAUDqoIACAAIAGgGIgBgBgAd8s5IgBgCIABgBIgBABIABACgAfwuaQhQAygZAbQgJAIgBAHQABgHAJgIQAZgbBQgyQAngLAggaQggAagnALgAZMt3IBtADIABgBIAJgMIABAAIgBAAIgJAMIhtgDgAbEuBQAvADAWgNQARgLAAgWIgBgKIARgSQANgOAMgGQAIgEAHAAIAAAAIgBgWIABAAQARgHAGgRIABAAIgBAAQgGARgRAHIgBAAIABAWQgHgBgIAFQgMAGgNAOIgRASIABAKQAAAWgRALQgWAMgvgCgEAhOgPXIAMgOIAcgBIAAgBIAAABIgcABIAAAAgEAhjgRkIgTAmIgBAqQAaAVAQAAIgDAYIABAAIADgZQgQAAgagVIABgpIATgnIgbgBgAd8wAIABAAQAAgTgTAFIAHgBQAMAAgBAPgAeEwEIgHAEIAHgEQAKgDAFAFIABAAQgFgGgLAEIAAAAgAeUwCQARgNAAgdIABAAIgBAAQAAAdgRANgAemwsIAAAAIAsgBIABgBgEAgBgRGQgbAMgTAMQATgMAbgMIAHgDIABAAIAAAAIAAAAIgBAAgEAgJgRJIADgCIADgCQAHgDATAFIAAgBQgDgHAAgFQAAgKAIgGIABAAIAaACIgagCIgBAAQgIAGAAAKQAAAFADAHQgUgFgGAEIgDACIAAAAIgDACIAAAAgAbmgRIANgRIgNARgAbzgigAcJjJgAcKjkIABgBIgBAaIgBACgAcLjlgAe2qCgAfKqYIACAAIgBASIgCABgAc/q/IAAgCIABAAIAAACgAc/q/gAc/q/gAc/q/gAc/rBIgBgJIABgDIABAMgAc/rBgAc/rNgAfyrhgEAgFgMJIABgIIABAAIgBAIgEAgHgMRgEAgvgN1IACAAIAAAbIgCABgEAgxgN1gEAhGgOpIgHgJIgBgDIgHgKIABgCIAPAXIAAABIgBARIgCABgEAgMgRLIAAAAIgDACIADgCgEAgMgRLg");
	this.shape_2.setTransform(396.1254,308.425);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_2},{t:this.shape_1},{t:this.shape}]}).wait(1));

	// Layer_4
	this.shape_3 = new cjs.Shape();
	this.shape_3.graphics.f("#C9E5D3").s().p("Eg+fAu4MAAAhdvMB8/AAAMAAABdvg");
	this.shape_3.setTransform(400,300);

	this.timeline.addTween(cjs.Tween.get(this.shape_3).wait(1));

	this._renderFirstFrame();

}).prototype = p = new lib.AnMovieClip();
p.nominalBounds = new cjs.Rectangle(400,128.7,400,471.3);
// library properties:
lib.properties = {
	id: '7BF6AD51D07CB14780071B0B96381FC2',
	width: 800,
	height: 600,
	fps: 30,
	color: "#C9E5D3",
	opacity: 1.00,
	manifest: [
		{src:"img\AndhraPradesh.png", id:"AndhraPradesh"},
		{src:"img/ArunachalPradesh.png", id:"ArunachalPradesh"},
		{src:"img/Andman11pngcopy2.png", id:"Andman11pngcopy2"},
		{src:"img/DadraNagarHaveli.png", id:"DadraNagarHaveli"},
		{src:"img/Assam.png", id:"Assam"},
		{src:"img/Chandigarh.png", id:"Chandigarh"},
		{src:"img/delhi.png", id:"delhi"},
		{src:"img/DamanDiu.png", id:"DamanDiu"},
		{src:"img/Gujarat.png", id:"Gujarat"},
		{src:"img/Himachalpngcopy.png", id:"Himachalpngcopy"},
		{src:"img/haryana.png", id:"haryana"},
		{src:"img/Bihar.png", id:"Bihar"},
		{src:"img/Jharkhandlogo.png", id:"Jharkhandlogo"},
		{src:"img/Karnataka.png", id:"Karnataka"},
		{src:"img/Lakshadweep.png", id:"Lakshadweep"},
		{src:"img/Kerala.png", id:"Kerala"},
		{src:"img/Maharashtra.png", id:"Maharashtra"},
		{src:"img/MadhyaPradeshUrjaVikasNigamLimitedlogo.png", id:"MadhyaPradeshUrjaVikasNigamLimitedlogo"},
		{src:"img/Mizoram.png", id:"Mizoram"},
		{src:"img/Manipur.png", id:"Manipur"},
		{src:"img/Nagaland.png", id:"Nagaland"},
		{src:"img/Odishapngcopy2.png", id:"Odishapngcopy2"},
		{src:"img/Meghalaya.png", id:"Meghalaya"},
		{src:"img/punjab.png", id:"punjab"},
		{src:"img/RajasthanRenewableEnergyCorporationLtd.png?1604309462979", id:"RajasthanRenewableEnergyCorporationLtd"},
		{src:"img/Puducherry.png?1604309462979", id:"Puducherry"},
		{src:"img/PDDlogo.png?1604309462979", id:"PDDlogo"},
		{src:"img/Sikkim.png?1604309462979", id:"Sikkim"},
		{src:"img/UttarPradesh.png?1604309462979", id:"UttarPradesh"},
		{src:"img/Telangana.png?1604309462979", id:"Telangana"},
		{src:"img/Tripura.png?1604309462979", id:"Tripura"},
		{src:"img/Chhattisgarh.png?1604309462979", id:"Chhattisgarh"},
		{src:"img/WestBengal.png?1604309462979", id:"WestBengal"},
		{src:"img/Uttarakhand.png?1604309462979", id:"Uttarakhand"},
		{src:"img/Goa.png?1604309462979", id:"Goa"}
	],
	preloads: []
};



// bootstrap callback support:

(lib.Stage = function(canvas) {
	createjs.Stage.call(this, canvas);
}).prototype = p = new createjs.Stage();

p.setAutoPlay = function(autoPlay) {
	this.tickEnabled = autoPlay;
}
p.play = function() { this.tickEnabled = true; this.getChildAt(0).gotoAndPlay(this.getTimelinePosition()) }
p.stop = function(ms) { if(ms) this.seek(ms); this.tickEnabled = false; }
p.seek = function(ms) { this.tickEnabled = true; this.getChildAt(0).gotoAndStop(lib.properties.fps * ms / 1000); }
p.getDuration = function() { return this.getChildAt(0).totalFrames / lib.properties.fps * 1000; }

p.getTimelinePosition = function() { return this.getChildAt(0).currentFrame / lib.properties.fps * 1000; }

an.bootcompsLoaded = an.bootcompsLoaded || [];
if(!an.bootstrapListeners) {
	an.bootstrapListeners=[];
}

an.bootstrapCallback=function(fnCallback) {
	an.bootstrapListeners.push(fnCallback);
	if(an.bootcompsLoaded.length > 0) {
		for(var i=0; i<an.bootcompsLoaded.length; ++i) {
			fnCallback(an.bootcompsLoaded[i]);
		}
	}
};

an.compositions = an.compositions || {};
an.compositions['7BF6AD51D07CB14780071B0B96381FC2'] = {
	getStage: function() { return exportRoot.stage; },
	getLibrary: function() { return lib; },
	getSpriteSheet: function() { return ss; },
	getImages: function() { return imgages; }
};

an.compositionLoaded = function(id) {
	an.bootcompsLoaded.push(id);
	for(var j=0; j<an.bootstrapListeners.length; j++) {
		an.bootstrapListeners[j](id);
	}
}

an.getComposition = function(id) {
	return an.compositions[id];
}


an.makeResponsive = function(isResp, respDim, isScale, scaleType, domContainers) {		
	var lastW, lastH, lastS=1;		
	window.addEventListener('resize', resizeCanvas);		
	resizeCanvas();		
	function resizeCanvas() {			
		var w = lib.properties.width, h = lib.properties.height;			
		var iw = window.innerWidth, ih=window.innerHeight;			
		var pRatio = window.devicePixelRatio || 1, xRatio=iw/w, yRatio=ih/h, sRatio=1;			
		if(isResp) {                
			if((respDim=='width'&&lastW==iw) || (respDim=='height'&&lastH==ih)) {                    
				sRatio = lastS;                
			}				
			else if(!isScale) {					
				if(iw<w || ih<h)						
					sRatio = Math.min(xRatio, yRatio);				
			}				
			else if(scaleType==1) {					
				sRatio = Math.min(xRatio, yRatio);				
			}				
			else if(scaleType==2) {					
				sRatio = Math.max(xRatio, yRatio);				
			}			
		}			
		domContainers[0].width = w * pRatio * sRatio;			
		domContainers[0].height = h * pRatio * sRatio;			
		domContainers.forEach(function(container) {				
			container.style.width = w * sRatio + 'px';				
			container.style.height = h * sRatio + 'px';			
		});			
		stage.scaleX = pRatio*sRatio;			
		stage.scaleY = pRatio*sRatio;			
		lastW = iw; lastH = ih; lastS = sRatio;            
		stage.tickOnUpdate = false;            
		stage.update();            
		stage.tickOnUpdate = true;		
	}
}
an.handleSoundStreamOnTick = function(event) {
	if(!event.paused){
		var stageChild = stage.getChildAt(0);
		if(!stageChild.paused){
			stageChild.syncStreamSounds();
		}
	}
}


})(createjs = createjs||{}, AdobeAn = AdobeAn||{});
var createjs, AdobeAn;