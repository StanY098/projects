﻿using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class CameraFollow : MonoBehaviour {
	public Transform target;
	public float smoothing = 3f;
	Vector3 offset;
    void Awake()
    {
        offset = transform.position - target.position;
    }
	void Start()
	{
        transform.position = target.position + offset;
	}

	void FixedUpdate()
	{
		Vector3  targetCamPos = target.position + offset;
		transform.position = Vector3.Lerp (transform.position, targetCamPos, smoothing * Time.deltaTime);
		
	}
}
