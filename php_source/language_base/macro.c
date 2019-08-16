#include<stdio.h>
#define MY_MACRO " a %s\n"
int main(){
    char *m = "macro";
    printf("This is " MY_MACRO, m);
    return 1;
}