// -------------------------------------------------------------------
// Switch Content Script- By Dynamic Drive, available at: http://www.dynamicdrive.com
// Created: Jan 5th, 2007
// April 5th: Added ability to persist content states by x days versus just session only
// -------------------------------------------------------------------

function switchcontent(className, filtertag){
	this.className=className
	this.collapsePrev=false //Default: Collapse previous content each time
	this.persistType="none" //Default: Disable persistence
	//Limit type of element to scan for on page for switch contents if 2nd function parameter is defined, for efficiency sake (ie: "div")
	this.filter_content_tag=(typeof filtertag!="undefined")? filtertag.toLowerCase() : ""
}

switchcontent.prototype.setStatus=function(openHTML, closeHTML){ //PUBLIC: Set open/ closing HTML indicator. Optional
	this.statusOpen=openHTML
	this.statusClosed=closeHTML
}

switchcontent.prototype.setColor=function(openColor, closeColor){ //PUBLIC: Set open/ closing color of switch header. Optional
	this.colorOpen=openColor
	this.colorClosed=closeColor
}

switchcontent.prototype.setPersist=function(bool, days){ //PUBLIC: Enable/ disable persistence. Default is false.
	if (bool==true){ //if enable persistence
		if (typeof days=="undefined") //if session only
			this.persistType="session"
		else{ //else if non session persistent
			this.persistType="days"
			this.persistDays=parseInt(days)
		}
	}
	else
		this.persistType="none"
}

switchcontent.prototype.collapsePrevious=function(bool){ //PUBLIC: Enable/ disable collapse previous content. Default is false.
	this.collapsePrev=bool
}


switchcontent.prototype.sweepToggle=function(setting){ //PUBLIC: Expor/ contract all contents method. (Values: "contract"|"expor")
	if (typeof this.headers!="undefined" && this.headers.length>0){ //if there are switch contents defined on the page
		for (var i=0; i<this.headers.length; i++){
			if (setting=="expor")
				this.exporcontent(this.headers[i]) //expor each content
			else if (setting=="contract")
				this.contractcontent(this.headers[i]) //contract each content
		}
	}
}


// -------------------------------------------------------------------
// PUBLIC: defaultExpored(indices_of_contents)- Set contents that should be expored by default when the page loads.
// Note that the persistence feature (if enabled) overrides this setting.
// Pass in the position of the contents relative to the rest of the contents ie: defaultExpored(0,2,3) would expor the 1st, 3rd, or 4th contents by default
// -------------------------------------------------------------------

switchcontent.prototype.defaultExpored=function(){
	var exporedindices=[] //Array to hold indices (position) of content to be expored by default
	//Loop through function arguments, or store each one within array
	//Two test conditions: 1) End of Arguments array, or 2) If "collapsePrev" is enabled, only the first entered index (as only 1 content can be expored at any time)
	for (var i=0; (!this.collapsePrev && i<arguments.length) || (this.collapsePrev && i==0); i++)
		exporedindices[exporedindices.length]=arguments[i]
	this.exporedindices=exporedindices.join(",") //convert array into a string of the format: "0,2,3" for later parsing by script
}


//PRIVATE: Sets color of switch header.

switchcontent.prototype.togglecolor=function(header, status){
	if (typeof this.colorOpen!="undefined")
		header.style.color=status
}


//PRIVATE: Sets status indicator HTML of switch header.

switchcontent.prototype.togglestatus=function(header, status){
	if (typeof this.statusOpen!="undefined")
		header.firstChild.innerHTML=status
}


//PRIVATE: Contracts a content based on its corresponding header entered

switchcontent.prototype.contractcontent=function(header){
	var innercontent=document.getElementById(header.id.replace("-title", "")) //Reference content for this header
	innercontent.style.display="none"
	this.togglestatus(header, this.statusClosed)
	this.togglecolor(header, this.colorClosed)
}


//PRIVATE: Expors a content based on its corresponding header entered

switchcontent.prototype.exporcontent=function(header){
	var innercontent=document.getElementById(header.id.replace("-title", ""))
	innercontent.style.display="block"
	this.togglestatus(header, this.statusOpen)
	this.togglecolor(header, this.colorOpen)
}

// -------------------------------------------------------------------
// PRIVATE: toggledisplay(header)- Toggles between a content being expored or contracted
// If "Collapse Previous" is enabled, contracts previous open content before exporing current
// -------------------------------------------------------------------

switchcontent.prototype.toggledisplay=function(header){
	var innercontent=document.getElementById(header.id.replace("-title", "")) //Reference content for this header
	if (innercontent.style.display=="block")
		this.contractcontent(header)
	else{
		this.exporcontent(header)
		if (this.collapsePrev && typeof this.prevHeader!="undefined" && this.prevHeader.id!=header.id) // If "Collapse Previous" is enabled or there's a previous open content
			this.contractcontent(this.prevHeader) //Contract that content first
	}
	if (this.collapsePrev)
		this.prevHeader=header //Set current expored content as the next "Previous Content"
}


// -------------------------------------------------------------------
// PRIVATE: collectElementbyClass()- Searches or stores all switch contents (based on shared class name) or their headers in two arrays
// Each content should carry an unique ID, or for its header, an ID equal to "CONTENTID-TITLE"
// -------------------------------------------------------------------

switchcontent.prototype.collectElementbyClass=function(classname){ //Returns an array containing DIVs with specified classname
	var classnameRE=new RegExp("(^|\\s+)"+classname+"($|\\s+)", "i") //regular expression to screen for classname within element
	this.headers=[], this.innercontents=[]
	if (this.filter_content_tag!="") //If user defined limit type of element to scan for to a certain element (ie: "div" only)
		var allelements=document.getElementsByTagName(this.filter_content_tag)
	else //else, scan all elements on the page!
		var allelements=document.all? document.all : document.getElementsByTagName("*")
	for (var i=0; i<allelements.length; i++){
		if (typeof allelements[i].className=="string" && allelements[i].className.search(classnameRE)!=-1){
			if (document.getElementById(allelements[i].id+"-title")!=null){ //if header exists for this inner content
				this.headers[this.headers.length]=document.getElementById(allelements[i].id+"-title") //store reference to header intended for this inner content
				this.innercontents[this.innercontents.length]=allelements[i] //store reference to this inner content
			}
		}
	}
}


//PRIVATE: init()- Initializes Switch Content function (collapse contents by default unless exception is found)

switchcontent.prototype.init=function(){
	var instanceOf=this
	this.collectElementbyClass(this.className) //Get all headers or its corresponding content based on shared class name of contents
	if (this.headers.length==0) //If no headers are present (no contents to switch), just exit
		return
	//If admin has changed number of days to persist from current cookie records, reset persistence by deleting cookie
	if (this.persistType=="days" && (parseInt(switchcontent.getCookie(this.className+"_dtrack"))!=this.persistDays))
		switchcontent.setCookie(this.className+"_d", "", -1) //delete cookie
	// Get ids of open contents below. Four possible scenerios:
	// 1) Session only persistence is enabled AND corresponding cookie contains a non blank ("") string
	// 2) Regular (in days) persistence is enabled AND corresponding cookie contains a non blank ("") string
	// 3) If there are contents that should be enabled by default (even if persistence is enabled or this IS the first page load)
	// 4) Default to no contents should be expored on page load ("" value)
	var opencontents_ids=(this.persistType=="session" && switchcontent.getCookie(this.className)!="")? ','+switchcontent.getCookie(this.className)+',' : (this.persistType=="days" && switchcontent.getCookie(this.className+"_d")!="")? ','+switchcontent.getCookie(this.className+"_d")+',' : (this.exporedindices)? ','+this.exporedindices+',' : ""
	for (var i=0; i<this.headers.length; i++){ //BEGIN FOR LOOP
		if (typeof this.statusOpen!="undefined") //If open/ closing HTML indicator is enabled/ set
			this.headers[i].innerHTML='<span class="status"></span>'+this.headers[i].innerHTML //Add a span element to original HTML to store indicator
		if (opencontents_ids.indexOf(','+i+',')!=-1){ //if index "i" exists within cookie string or default-enabled string (i=position of the content to expor)
			this.exporcontent(this.headers[i]) //Expor each content per stored indices (if ""Collapse Previous" is set, only one content)
			if (this.collapsePrev) //If "Collapse Previous" set
			this.prevHeader=this.headers[i]  //Indicate the expored content's corresponding header as the last clicked on header (for logic purpose)
		}
		else //else if no indices found in stored string
			this.contractcontent(this.headers[i]) //Contract each content by default
		this.headers[i].onclick=function(){instanceOf.toggledisplay(this)}
	} //END FOR LOOP
	switchcontent.dotask(window, function(){instanceOf.rememberpluscleanup()}, "unload") //Call persistence method onunload
}


// -------------------------------------------------------------------
// PRIVATE: rememberpluscleanup()- Stores the indices of content that are expored inside session only cookie
// If "Collapse Previous" is enabled, only 1st expored content index is stored
// -------------------------------------------------------------------

//Function to store index of opened ULs relative to other ULs in Tree into cookie:
switchcontent.prototype.rememberpluscleanup=function(){
	//Define array to hold ids of open content that should be persisted
	//Default to just "none" to account for the case where no contents are open when user leaves the page (or persist that):
	var opencontents=new Array("none")
	for (var i=0; i<this.innercontents.length; i++){
		//If persistence enabled, content in question is expored, or either "Collapse Previous" is disabled, or if enabled, this is the first expored content
		if (this.persistType!="none" && this.innercontents[i].style.display=="block" && (!this.collapsePrev || (this.collapsePrev && opencontents.length<2)))
			opencontents[opencontents.length]=i //save the index of the opened UL (relative to the entire list of ULs) as an array element
		this.headers[i].onclick=null //Cleanup code
	}
	if (opencontents.length>1) //If there exists open content to be persisted
		opencontents.shift() //Boot the "none" value from the array, so all it contains are the ids of the open contents
	if (typeof this.statusOpen!="undefined")
		this.statusOpen=this.statusClosed=null //Cleanup code
	if (this.persistType=="session") //if session only cookie set
		switchcontent.setCookie(this.className, opencontents.join(",")) //populate cookie with indices of open contents: classname=1,2,3,etc
	else if (this.persistType=="days" && typeof this.persistDays=="number"){ //if persistent cookie set instead
		switchcontent.setCookie(this.className+"_d", opencontents.join(","), this.persistDays) //populate cookie with indices of open contents
		switchcontent.setCookie(this.className+"_dtrack", this.persistDays, this.persistDays) //also remember number of days to persist (int)
	}
}


// -------------------------------------------------------------------
// A few utility functions below:
// -------------------------------------------------------------------


switchcontent.dotask=function(target, functionref, tasktype){ //assign a function to execute to an event horler (ie: onunload)
	var tasktype=(window.addEventListener)? tasktype : "on"+tasktype
	if (target.addEventListener)
		target.addEventListener(tasktype, functionref, false)
	else if (target.attachEvent)
		target.attachEvent(tasktype, functionref)
}

switchcontent.getCookie=function(Name){ 
	var re=new RegExp(Name+"=[^;]+", "i"); //construct RE to search for target name/value pair
	if (document.cookie.match(re)) //if cookie found
		return document.cookie.match(re)[0].split("=")[1] //return its value
	return ""
}

switchcontent.setCookie=function(name, value, days){
	if (typeof days!="undefined"){ //if set persistent cookie
		var expireDate = new Date()
		var expstring=expireDate.setDate(expireDate.getDate()+days)
		document.cookie = name+"="+value+"; expires="+expireDate.toGMTString()
	}
	else //else if this is a session only cookie
		document.cookie = name+"="+value
}