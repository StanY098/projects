using UnityEngine.UI;
using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class BossManager : MonoBehaviour {

    public GameObject boss;
    public GameObject bossSlider;
    public GameObject text;
    float timer = 50f;
    public static bool appeared;
	// Use this for initialization
	void Start () {
        boss.SetActive(false);
        bossSlider.SetActive(false);
        appeared = false;
	}
	
	// Update is called once per frame
	void Update () {
        timer -= 1f * Time.deltaTime;
        if(timer <= 0)
        {
            boss.SetActive(true);
            bossSlider.SetActive(true);
            text.SetActive(true);
            appeared = true;
        }
	}
}
