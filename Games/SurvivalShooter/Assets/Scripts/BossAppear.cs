using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class BossAppear : MonoBehaviour {
    Vector3 movement;
    float speed = 9f;
    float timer = 5f;
	// Use this for initialization
	void Start () {
        this.gameObject.SetActive(false);
        movement = new Vector3(-3f, 0f, 0f);
	}
	
	// Update is called once per frame
	void Update () {
        if (this.gameObject.activeSelf)
        {
            transform.position -= movement * speed;
        }
        timer -= 1f * Time.deltaTime;
        if(timer <= 0)
        {
            this.gameObject.SetActive(false);
        }
	}
}
