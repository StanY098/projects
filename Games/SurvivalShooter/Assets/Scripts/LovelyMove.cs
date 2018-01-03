using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class LovelyMove : MonoBehaviour {

    Vector3 movement;
    float offsetX;
    float offsetY;
    float offsetZ;
    float magnitude;
    float Ymagnitude;
    //Animator anim;
    // Use this for initialization
    void Start () {
        offsetX = 3f;
        offsetY = 0f;
        offsetZ = 0f;
        magnitude = 1;
        Ymagnitude = 1;
    }
	
	// Update is called once per frame
	void Update () {
        movement = new Vector3(offsetX, offsetY, offsetZ) * Time.deltaTime;
        this.gameObject.transform.position += movement * magnitude;
        if (this.gameObject.transform.position.y <= -30f || this.gameObject.transform.position.y >= 30f)
        {
            Ymagnitude = -Ymagnitude;
        }
        if (this.gameObject.transform.position.x >= 95f || this.gameObject.transform.position.x <= -95f)
        {
            this.gameObject.transform.Rotate(new Vector3(0f,180f,0f));
            magnitude = -magnitude;
            movement = new Vector3(0f, 12f, offsetZ);
            this.gameObject.transform.position += movement * Ymagnitude;
        }
    }
}
