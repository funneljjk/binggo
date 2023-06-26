
function userHome(){
	window.location.href = '/고객-메인';
}
function findExpert() {
	window.location.href = '/고객-전문가찾기_의뢰신청';
}
function goMarket() {
	window.location.href = '/shop';
}
function listConst() {
	window.location.href = '/고객-의뢰내역-견적as';
}
function expertHome() {
	window.location.href = '/전문가-메인';
}
function findConst() {
	window.location.href = '/전문가-의뢰찾기';
}
function ingConst() {
	window.location.href = '/전문가-시공-완료';
}
function profile() {
	window.location.href = '/전문가-프로필';
}
function aram() {
	window.location.href = '/알림';
}
function changeExpert() {
	window.location.href = '/전문가-메인';
}
function changeUser() {
	window.location.href = '/고객-메인';
}



// 뒤로가기
document.addEventListener('DOMContentLoaded', function() {
	var backArrow = document.querySelector('.backArrow');

	if (backArrow) {
		backArrow.addEventListener('click', function() {
			window.history.back();
		});
	}
});


//하트 색상 변환
function toggleHeartColor(element) {
	const defaultColor = '#ededed';
	const activeColor = 'red';
  
	if (element.style.color === activeColor) {
	  element.style.color = defaultColor;
	} else {
	  element.style.color = activeColor;
	}
}

function toggleHeartColorList(element){
	const defaultColor = '#ededed';
	const activeColor = 'red';
  
	if (element.style.color === activeColor) {
	  element.style.color = defaultColor;
	} else {
	  element.style.color = activeColor;
	}
	
	const heartBtn = document.getElementById("heartBtn");
	const heartBtn2List = document.getElementsByClassName("heartBtn2");
	const hrList = document.getElementsByClassName("hr_001");

	for (let i = 0; i < heartBtn2List.length; i++) {
		const parentUl = heartBtn2List[i].closest("ul");
		if (heartBtn.style.color === "red" && heartBtn2List[i].style.color === "red") {
			parentUl.classList.remove("hidden");
			hrList[i].classList.remove("hidden");
		} else if (heartBtn.style.color === "red") {
			parentUl.classList.add("hidden");
			hrList[i].classList.add("hidden");
		} else {
			parentUl.classList.remove("hidden");
			hrList[i].classList.remove("hidden");
		}
	}
}


