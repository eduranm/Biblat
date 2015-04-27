function stackBlurImage(a,t,e,r){var n=document.getElementById(a),l=n.naturalWidth,g=n.naturalHeight,c=document.getElementById(t);c.style.width=l+"px",c.style.height=g+"px",c.width=l,c.height=g;var o=c.getContext("2d");o.clearRect(0,0,l,g),o.drawImage(n,0,0),isNaN(e)||1>e||(r?stackBlurCanvasRGBA(t,0,0,l,g,e):stackBlurCanvasRGB(t,0,0,l,g,e))}function stackBlurCanvasRGBA(a,t,e,r,n,l){if(!(isNaN(l)||1>l)){l|=0;var g,c=document.getElementById(a),o=c.getContext("2d");try{try{g=o.getImageData(t,e,r,n)}catch(s){try{netscape.security.PrivilegeManager.enablePrivilege("UniversalBrowserRead"),g=o.getImageData(t,e,r,n)}catch(s){throw alert("Cannot access local image"),new Error("unable to access local image data: "+s)}}}catch(s){throw alert("Cannot access image"),new Error("unable to access image data: "+s)}var i,u,b,m,f,h,x,d,v,B,w,y,I,C,k,E,R,p,D,N,_,S,G,P,A=g.data,M=l+l+1,U=r-1,H=n-1,W=l+1,j=W*(W+1)/2,q=new BlurStack,z=q;for(b=1;M>b;b++)if(z=z.next=new BlurStack,b==W)var F=z;z.next=q;var J=null,K=null;x=h=0;var L=mul_table[l],O=shg_table[l];for(u=0;n>u;u++){for(E=R=p=D=d=v=B=w=0,y=W*(N=A[h]),I=W*(_=A[h+1]),C=W*(S=A[h+2]),k=W*(G=A[h+3]),d+=j*N,v+=j*_,B+=j*S,w+=j*G,z=q,b=0;W>b;b++)z.r=N,z.g=_,z.b=S,z.a=G,z=z.next;for(b=1;W>b;b++)m=h+((b>U?U:b)<<2),d+=(z.r=N=A[m])*(P=W-b),v+=(z.g=_=A[m+1])*P,B+=(z.b=S=A[m+2])*P,w+=(z.a=G=A[m+3])*P,E+=N,R+=_,p+=S,D+=G,z=z.next;for(J=q,K=F,i=0;r>i;i++)A[h+3]=G=w*L>>O,0!=G?(G=255/G,A[h]=(d*L>>O)*G,A[h+1]=(v*L>>O)*G,A[h+2]=(B*L>>O)*G):A[h]=A[h+1]=A[h+2]=0,d-=y,v-=I,B-=C,w-=k,y-=J.r,I-=J.g,C-=J.b,k-=J.a,m=x+((m=i+l+1)<U?m:U)<<2,E+=J.r=A[m],R+=J.g=A[m+1],p+=J.b=A[m+2],D+=J.a=A[m+3],d+=E,v+=R,B+=p,w+=D,J=J.next,y+=N=K.r,I+=_=K.g,C+=S=K.b,k+=G=K.a,E-=N,R-=_,p-=S,D-=G,K=K.next,h+=4;x+=r}for(i=0;r>i;i++){for(R=p=D=E=v=B=w=d=0,h=i<<2,y=W*(N=A[h]),I=W*(_=A[h+1]),C=W*(S=A[h+2]),k=W*(G=A[h+3]),d+=j*N,v+=j*_,B+=j*S,w+=j*G,z=q,b=0;W>b;b++)z.r=N,z.g=_,z.b=S,z.a=G,z=z.next;for(f=r,b=1;l>=b;b++)h=f+i<<2,d+=(z.r=N=A[h])*(P=W-b),v+=(z.g=_=A[h+1])*P,B+=(z.b=S=A[h+2])*P,w+=(z.a=G=A[h+3])*P,E+=N,R+=_,p+=S,D+=G,z=z.next,H>b&&(f+=r);for(h=i,J=q,K=F,u=0;n>u;u++)m=h<<2,A[m+3]=G=w*L>>O,G>0?(G=255/G,A[m]=(d*L>>O)*G,A[m+1]=(v*L>>O)*G,A[m+2]=(B*L>>O)*G):A[m]=A[m+1]=A[m+2]=0,d-=y,v-=I,B-=C,w-=k,y-=J.r,I-=J.g,C-=J.b,k-=J.a,m=i+((m=u+W)<H?m:H)*r<<2,d+=E+=J.r=A[m],v+=R+=J.g=A[m+1],B+=p+=J.b=A[m+2],w+=D+=J.a=A[m+3],J=J.next,y+=N=K.r,I+=_=K.g,C+=S=K.b,k+=G=K.a,E-=N,R-=_,p-=S,D-=G,K=K.next,h+=r}o.putImageData(g,t,e)}}function stackBlurCanvasRGB(a,t,e,r,n,l){if(!(isNaN(l)||1>l)){l|=0;var g,c=document.getElementById(a),o=c.getContext("2d");try{try{g=o.getImageData(t,e,r,n)}catch(s){try{netscape.security.PrivilegeManager.enablePrivilege("UniversalBrowserRead"),g=o.getImageData(t,e,r,n)}catch(s){throw alert("Cannot access local image"),new Error("unable to access local image data: "+s)}}}catch(s){throw alert("Cannot access image"),new Error("unable to access image data: "+s)}var i,u,b,m,f,h,x,d,v,B,w,y,I,C,k,E,R,p,D,N,_=g.data,S=l+l+1,G=r-1,P=n-1,A=l+1,M=A*(A+1)/2,U=new BlurStack,H=U;for(b=1;S>b;b++)if(H=H.next=new BlurStack,b==A)var W=H;H.next=U;var j=null,q=null;x=h=0;var z=mul_table[l],F=shg_table[l];for(u=0;n>u;u++){for(C=k=E=d=v=B=0,w=A*(R=_[h]),y=A*(p=_[h+1]),I=A*(D=_[h+2]),d+=M*R,v+=M*p,B+=M*D,H=U,b=0;A>b;b++)H.r=R,H.g=p,H.b=D,H=H.next;for(b=1;A>b;b++)m=h+((b>G?G:b)<<2),d+=(H.r=R=_[m])*(N=A-b),v+=(H.g=p=_[m+1])*N,B+=(H.b=D=_[m+2])*N,C+=R,k+=p,E+=D,H=H.next;for(j=U,q=W,i=0;r>i;i++)_[h]=d*z>>F,_[h+1]=v*z>>F,_[h+2]=B*z>>F,d-=w,v-=y,B-=I,w-=j.r,y-=j.g,I-=j.b,m=x+((m=i+l+1)<G?m:G)<<2,C+=j.r=_[m],k+=j.g=_[m+1],E+=j.b=_[m+2],d+=C,v+=k,B+=E,j=j.next,w+=R=q.r,y+=p=q.g,I+=D=q.b,C-=R,k-=p,E-=D,q=q.next,h+=4;x+=r}for(i=0;r>i;i++){for(k=E=C=v=B=d=0,h=i<<2,w=A*(R=_[h]),y=A*(p=_[h+1]),I=A*(D=_[h+2]),d+=M*R,v+=M*p,B+=M*D,H=U,b=0;A>b;b++)H.r=R,H.g=p,H.b=D,H=H.next;for(f=r,b=1;l>=b;b++)h=f+i<<2,d+=(H.r=R=_[h])*(N=A-b),v+=(H.g=p=_[h+1])*N,B+=(H.b=D=_[h+2])*N,C+=R,k+=p,E+=D,H=H.next,P>b&&(f+=r);for(h=i,j=U,q=W,u=0;n>u;u++)m=h<<2,_[m]=d*z>>F,_[m+1]=v*z>>F,_[m+2]=B*z>>F,d-=w,v-=y,B-=I,w-=j.r,y-=j.g,I-=j.b,m=i+((m=u+A)<P?m:P)*r<<2,d+=C+=j.r=_[m],v+=k+=j.g=_[m+1],B+=E+=j.b=_[m+2],j=j.next,w+=R=q.r,y+=p=q.g,I+=D=q.b,C-=R,k-=p,E-=D,q=q.next,h+=r}o.putImageData(g,t,e)}}function BlurStack(){this.r=0,this.g=0,this.b=0,this.a=0,this.next=null}var mul_table=[512,512,456,512,328,456,335,512,405,328,271,456,388,335,292,512,454,405,364,328,298,271,496,456,420,388,360,335,312,292,273,512,482,454,428,405,383,364,345,328,312,298,284,271,259,496,475,456,437,420,404,388,374,360,347,335,323,312,302,292,282,273,265,512,497,482,468,454,441,428,417,405,394,383,373,364,354,345,337,328,320,312,305,298,291,284,278,271,265,259,507,496,485,475,465,456,446,437,428,420,412,404,396,388,381,374,367,360,354,347,341,335,329,323,318,312,307,302,297,292,287,282,278,273,269,265,261,512,505,497,489,482,475,468,461,454,447,441,435,428,422,417,411,405,399,394,389,383,378,373,368,364,359,354,350,345,341,337,332,328,324,320,316,312,309,305,301,298,294,291,287,284,281,278,274,271,268,265,262,259,257,507,501,496,491,485,480,475,470,465,460,456,451,446,442,437,433,428,424,420,416,412,408,404,400,396,392,388,385,381,377,374,370,367,363,360,357,354,350,347,344,341,338,335,332,329,326,323,320,318,315,312,310,307,304,302,299,297,294,292,289,287,285,282,280,278,275,273,271,269,267,265,263,261,259],shg_table=[9,11,12,13,13,14,14,15,15,15,15,16,16,16,16,17,17,17,17,17,17,17,18,18,18,18,18,18,18,18,18,19,19,19,19,19,19,19,19,19,19,19,19,19,19,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24];