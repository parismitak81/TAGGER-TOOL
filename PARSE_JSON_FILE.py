#!/usr/bin/env python
# coding: utf-8

# In[ ]:


from cassandra.cluster import Cluster
cluster = Cluster(['127.0.0.1'])
#keyspace name=cassandra
session = cluster.connect('cassandra') 
import json
import re


#opening the file
with open ('2L_5mtYDHBI.json') as json_file:
    data=json.load(json_file)
    for data1 in data['videoInfo']:
        data2=(data1['snippet'])
    for data3 in data['comments']:
        data4=(data3['snippet'])   
        data5=(data4['topLevelComment'])
        data6=(data5['id'])
        data7=(data5['snippet'])
        data8=(data7['textOriginal'])
        data9=(re.split('\n|\.+|\?|\,+|\!',data8))
        
        #splitting acquired data
        for i in range(len(data9)):
            dict1={ data6:i }
            j=data9[i].strip()
            dict2={data6:j}
            if dict2[data6]=='':
                del dict2[data6]
            else:
                
                #inserting values into table
                session.execute("insert into final1(video_id,published_at,comment_id,sentence_id,comment) values(%s,%s,%s,%s,%s)",(data['videoId'],data2['publishedAt'],data5['id'],dict1[data6],dict2[data6]))
        
        #extracting reply comments
        if "replyComments" in data3:
            for r1 in data3['replyComments']:
                r2=(r1['snippet'])
                r3=(r1['id'])
                r4=(r2['textOriginal'])
                list1=(re.split('\n|\.+|\?|\,+|\!|\++',r4))
                
                #splitting acquired data
                for i in range(len(list1)):
                    dict11={ r3:i }
                    j1=list1[i].strip()
                    dict12={r3:j1}
                    if dict12[r3]=='':
                        del dict12[r3]
                    else:
                        
                        #inserting values into table
                        session.execute("insert into final1(video_id,published_at,comment_id,sentence_id,comment) values(%s,%s,%s,%s,%s)",(data['videoId'],data2['publishedAt'],r1['id'],dict11[r3],dict12[r3]))

